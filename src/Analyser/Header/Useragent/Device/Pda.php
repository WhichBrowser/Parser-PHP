<?php

namespace WhichBrowser\Analyser\Header\Useragent\Device;

use WhichBrowser\Constants;
use WhichBrowser\Data;
use WhichBrowser\Model\Version;

trait Pda
{
    private function detectPda($ua)
    {
        if (!preg_match('/(CASIO|Palm|pdQ|COM|airboard|sharp|pda|POCKET-E|OASYS|NTT\/PI)/ui', $ua)) {
            return;
        }

        $this->detectCasio($ua);
        $this->detectPalm($ua);
        $this->detectSonyMylo($ua);
        $this->detectSonyAirboard($ua);
        $this->detectSharpZaurus($ua);
        $this->detectSharpShoin($ua);
        $this->detectPanasonicPocketE($ua);
        $this->detectFujitsuOasys($ua);
        $this->detectNttPetitWeb($ua);
    }





    /* Casio */

    private function detectCasio($ua)
    {
        if (preg_match('/Product\=CASIO\/([^\);]+)[\);]/ui', $ua, $match)) {
            $this->data->device->manufacturer = 'Casio';
            $this->data->device->identified |= Constants\Id::MATCH_UA;
            $this->data->device->type = Constants\DeviceType::PDA;

            if ($match[1] == 'CASSIOPEIA BE') {
                $this->data->device->model = 'Cassiopeia';
            }

            if ($match[1] == 'PPP101') {
                $this->data->device->model = 'Pocket PostPet';
                $this->data->device->carrier = 'DoCoMo';
            }
        }
    }


    /* Palm */

    private function detectPalm($ua)
    {
        if (preg_match('/PalmOS/iu', $ua, $match)) {
            $this->data->os->name = 'Palm OS';
            $this->data->device->type = Constants\DeviceType::PDA;

            if (preg_match('/PalmOS ([0-9.]*)/iu', $ua, $match)) {
                $this->data->os->version = new Version([ 'value' => $match[1] ]);
            }

            if (preg_match('/; ([^;)]+)\)/u', $ua, $match)) {
                $device = Data\DeviceModels::identify('palmos', $match[1]);

                if ($device->identified) {
                    $device->identified |= $this->data->device->identified;
                    $this->data->device = $device;
                }
            }

            if (preg_match('/PalmOS\/([a-z]+)\/model ([^\/]+)\//iu', $ua, $match)) {
                $device = Data\DeviceModels::identify('palmos', $match[1] . '-' . $match[2]);

                if ($device->identified) {
                    $device->identified |= $this->data->device->identified;
                    $this->data->device = $device;
                }
            }
        }

        if (preg_match('/Palm OS ([0-9.]*)/iu', $ua, $match)) {
            $this->data->os->name = 'Palm OS';
            $this->data->os->version = new Version([ 'value' => $match[1] ]);
            $this->data->device->type = Constants\DeviceType::PDA;
        }

        if (preg_match('/PalmSource/u', $ua, $match)) {
            $this->data->os->name = 'Palm OS';
            $this->data->os->version = null;
            $this->data->device->type = Constants\DeviceType::PDA;

            if (preg_match('/PalmSource\/([^;]+)/u', $ua, $match)) {
                $this->data->device->model = $match[1];
                $this->data->device->identified = Constants\Id::PATTERN;
            }

            if (isset($this->data->device->model) && $this->data->device->model) {
                $device = Data\DeviceModels::identify('palmos', $this->data->device->model);

                if ($device->identified) {
                    $device->identified |= $this->data->device->identified;
                    $this->data->device = $device;
                }
            }
        }

        /* Some model markers */

        if (preg_match('/PalmPilot Pro/ui', $ua, $match)) {
            $this->data->device->manufacturer = 'Palm';
            $this->data->device->model = 'Pilot Professional';
            $this->data->device->identified |= Constants\Id::MATCH_UA;
        }

        if (preg_match('/pdQbrowser/ui', $ua, $match)) {
            $this->data->device->manufacturer = 'Kyocera';
            $this->data->device->model = 'QCP-6035';
            $this->data->device->identified |= Constants\Id::MATCH_UA;
        }
    }


    /* Sony Mylo */

    private function detectSonyMylo($ua)
    {
        if (preg_match('/SONY\/COM([0-9])/ui', $ua, $match)) {
            $this->data->device->manufacturer = 'Sony';
            $this->data->device->model = 'Mylo ' . $match[1];
            $this->data->device->identified |= Constants\Id::MATCH_UA;
            $this->data->device->type = Constants\DeviceType::PDA;

            $this->data->os->reset();

            if (preg_match('/Qt embedded/ui', $ua, $match)) {
                $this->data->os->name = 'Qtopia';
            }
        }
    }


    /* Sony Airboard */

    private function detectSonyAirboard($ua)
    {
        if (preg_match('/SONY\/airboard\/IDT-([A-Z0-9]+)/ui', $ua, $match)) {
            $this->data->device->manufacturer = 'Sony';
            $this->data->device->model = 'Airboard ' . $match[1];
            $this->data->device->identified |= Constants\Id::MATCH_UA;
            $this->data->device->type = Constants\DeviceType::PDA;
        }

        if (preg_match('/LocationFreeTV; Airboard\/(LF-[A-Z0-9]+)/ui', $ua, $match)) {
            $this->data->device->manufacturer = 'Sony';
            $this->data->device->model = 'Airboard ' . $match[1];
            $this->data->device->identified |= Constants\Id::MATCH_UA;
            $this->data->device->type = Constants\DeviceType::PDA;
        }
    }


    /* Sharp Zaurus */

    private function detectSharpZaurus($ua)
    {
        if (preg_match('/sharp pda browser\/([0-9\.]+)/ui', $ua, $match)) {
            $this->data->device->manufacturer = 'Sharp';
            $this->data->device->model = 'Zaurus';
            $this->data->device->type = Constants\DeviceType::PDA;

            if (preg_match('/\(([A-Z0-9\-]+)\/[0-9\.]+\)/ui', $ua, $match)) {
                $this->data->device->model = 'Zaurus ' . $match[1];
                $this->data->device->identified |= Constants\Id::MATCH_UA;
                $this->data->device->generic = false;
            }
        }

        if (preg_match('/\(PDA; (SL-[A-Z][0-9]+)\/[0-9\.]/ui', $ua, $match)) {
            $this->data->device->manufacturer = 'Sharp';
            $this->data->device->model = 'Zaurus ' . $match[1];
            $this->data->device->type = Constants\DeviceType::PDA;
            $this->data->device->identified |= Constants\Id::MATCH_UA;
            $this->data->device->generic = false;
        }
    }


    /* Sharp Shoin (Word Processor) */

    private function detectSharpShoin($ua)
    {
        if (preg_match('/sharp wd browser\/([0-9\.]+)/ui', $ua, $match)) {
            $this->data->device->manufacturer = 'Sharp';
            $this->data->device->model = 'Mobile Shoin';
            $this->data->device->type = Constants\DeviceType::PDA;

            if (preg_match('/\(([A-Z0-9\-]+)\/[0-9\.]+\)/ui', $ua, $match)) {
                $this->data->device->model = 'Mobile Shoin ' . $match[1];
                $this->data->device->identified |= Constants\Id::MATCH_UA;
                $this->data->device->generic = false;
            }
        }
    }


    /* Panasonic POCKET・E */

    private function detectPanasonicPocketE($ua)
    {
        if (preg_match('/Product\=Panasonic\/POCKET-E/ui', $ua, $match)) {
            $this->data->device->manufacturer = 'Panasonic';
            $this->data->device->model = 'POCKET・E';
            $this->data->device->type = Constants\DeviceType::PDA;
            $this->data->device->identified |= Constants\Id::MATCH_UA;
            $this->data->device->generic = false;
        }
    }


    /* Fujitsu OASYS */

    private function detectFujitsuOasys($ua)
    {
        if (preg_match('/Fujitsu; OASYS/ui', $ua, $match)) {
            $this->data->device->manufacturer = 'Fujitsu';
            $this->data->device->model = 'OASYS';
            $this->data->device->type = Constants\DeviceType::PDA;
            $this->data->device->identified |= Constants\Id::MATCH_UA;
            $this->data->device->generic = false;

            if (preg_match('/eNavigator/ui', $ua, $match)) {
                $this->data->browser->name = 'eNavigator';
                $this->data->browser->version = null;
                $this->data->browser->type = Constants\BrowserType::BROWSER;
            }
        }
    }


    /* PetitWeb */

    private function detectNttPetitWeb($ua)
    {
        if (preg_match('/Product\=NTT\/(PI-[0-9]+)/ui', $ua, $match)) {
            $this->data->device->manufacturer = 'NTT';
            $this->data->device->model = 'PetitWeb ' . $match[1];
            $this->data->device->type = Constants\DeviceType::PDA;
            $this->data->device->identified |= Constants\Id::MATCH_UA;
            $this->data->device->generic = false;
        }
    }
}
