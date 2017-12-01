<?php

namespace WhichBrowser\Model;

use WhichBrowser\Model\Browser;
use WhichBrowser\Model\Engine;
use WhichBrowser\Model\Os;
use WhichBrowser\Model\Device;

class Main
{
    /**
     * @var \WhichBrowser\Model\Browser  $browser      Information about the browser
     */
    public $browser;

    /**
     * @var \WhichBrowser\Model\Engine   $engine       Information about the rendering engine
     */
    public $engine;

    /**
     * @var \WhichBrowser\Model\Os       $os           Information about the operating system
     */
    public $os;

    /**
     * @var \WhichBrowser\Model\Device   $device       Information about the device
     */
    public $device;

    /**
     * @var boolean                      $camouflage   Is the browser camouflaged as another browser
     */
    public $camouflage = false;

    /**
     * @var int[]                        $features
     */
    public $features = [];


    /**
     * Create default objects
     */

    public function __construct()
    {
        $this->browser = new Browser();
        $this->engine = new Engine();
        $this->os = new Os();
        $this->device = new Device();
    }


    /**
     * Check the name of a property and optionally is a specific version
     *
     * @internal
     *
     * @param  string   The name of the property, such as 'browser', 'engine' or 'os'
     * @param  string   The name of the browser that is checked
     * @param  string   Optional, the operator, must be <, <=, =, >= or >
     * @param  mixed    Optional, the value, can be an integer, float or string with a version number
     *
     * @return boolean
     */

    private function isX()
    {
        $arguments = func_get_args();
        $x = $arguments[0];
        
        if (count($arguments) < 2) {
            return false;
        }

        if (empty($this->$x->name)) {
            return false;
        }
    
        if ($this->$x->name != $arguments[1]) {
            return false;
        }
    
        if (count($arguments) >= 4) {
            if (empty($this->$x->version)) {
                return false;
            }

            if (!$this->$x->version->is($arguments[2], $arguments[3])) {
                return false;
            }
        }

        return true;
    }


    /**
     * Check the name of the browser and optionally is a specific version
     *
     * @param  string   The name of the browser that is checked
     * @param  string   Optional, the operator, must be <, <=, =, >= or >
     * @param  mixed    Optional, the value, can be an integer, float or string with a version number
     *
     * @return boolean
     */

    public function isBrowser()
    {
        $arguments = func_get_args();
        array_unshift($arguments, 'browser');
        return call_user_func_array([ $this, 'isX' ], $arguments);
    }


    /**
     * Check the name of the rendering engine and optionally is a specific version
     *
     * @param  string   The name of the rendering engine that is checked
     * @param  string   Optional, the operator, must be <, <=, =, >= or >
     * @param  mixed    Optional, the value, can be an integer, float or string with a version number
     *
     * @return boolean
     */

    public function isEngine()
    {
        $arguments = func_get_args();
        array_unshift($arguments, 'engine');
        return call_user_func_array([ $this, 'isX' ], $arguments);
    }


    /**
     * Check the name of the operating system and optionally is a specific version
     *
     * @param  string   The name of the operating system that is checked
     * @param  string   Optional, the operator, must be <, <=, =, >= or >
     * @param  mixed    Optional, the value, can be an integer, float or string with a version number
     *
     * @return boolean
     */

    public function isOs()
    {
        $arguments = func_get_args();
        array_unshift($arguments, 'os');
        return call_user_func_array([ $this, 'isX' ], $arguments);
    }


    /**
     * Check if the detected browser is of the specified type
     *
     * @param  string   $model      The type, or a combination of type and subtime joined with a semicolon.
     *
     * @return boolean
     */

    public function isDevice($model)
    {
        return (!empty($this->device->series) && $this->device->series == $model) || (!empty($this->device->model) && $this->device->model == $model);
    }


    /**
     * Get the type and subtype, separated by a semicolon (if applicable)
     *
     * @return string
     */

    public function getType()
    {
        return $this->device->type . (!empty($this->device->subtype) ? ':' . $this->device->subtype : '');
    }


    /**
     * Check if the detected browser is of the specified type
     *
     * @param  string   The type, or a combination of type and subtype joined with a semicolon.
     * @param  string   Unlimited optional types to check
     *
     * @return boolean
     */

    public function isType()
    {
        $arguments = func_get_args();

        $count = count($arguments);
        for ($a = 0; $a < $count; $a++) {
            if (strpos($arguments[$a], ':') !== false) {
                list($type, $subtype) = explode(':', $arguments[$a]);
                if ($type == $this->device->type && $subtype == $this->device->subtype) {
                    return true;
                }
            } else {
                if ($arguments[$a] == $this->device->type) {
                    return true;
                }
            }
        }

        return false;
    }


    /**
     * Check if the detected browser is a mobile device
     *
     * @return boolean
     */

    public function isMobile()
    {
        return $this->isType('mobile', 'tablet', 'ereader', 'media', 'watch', 'camera', 'gaming:portable');
    }


    /**
     * Check if a browser was detected
     *
     * @return boolean
     */

    public function isDetected()
    {
        return $this->browser->isDetected() || $this->os->isDetected() || $this->engine->isDetected() || $this->device->isDetected();
    }


    /**
     * Return the input string prefixed with 'a' or 'an' depending on the first letter of the string
     *
     * @internal
     *
     * @param  string   $s      The string that will be prefixed
     *
     * @return string
     */

    private function a($s)
    {
        return (preg_match("/^[aeiou]/i", $s) ? 'an ' : 'a ') . $s;
    }


    /**
     * Get a human readable string of the whole browser identification
     *
     * @return string
     */

    public function toString()
    {
        $prefix = $this->camouflage ? 'an unknown browser that imitates ' : '';
        $browser = $this->browser->toString();
        $os = $this->os->toString();
        $engine = $this->engine->toString();
        $device = $this->device->toString();
        

        if (empty($device) && empty($os) && $this->device->type == 'television') {
            $device = 'television';
        }

        if (empty($device) && $this->device->type == 'emulator') {
            $device = 'emulator';
        }

    
        if (!empty($browser) && !empty($os) && !empty($device)) {
            return $prefix . $browser . ' on ' . $this->a($device) . ' running ' . $os;
        }

        if (!empty($browser) && empty($os) && !empty($device)) {
            return $prefix . $browser . ' on ' . $this->a($device);
        }

        if (!empty($browser) && !empty($os) && empty($device)) {
            return $prefix . $browser . ' on ' . $os;
        }

        if (empty($browser) && !empty($os) && !empty($device)) {
            return $prefix . $this->a($device) . ' running ' . $os;
        }

        if (!empty($browser) && empty($os) && empty($device)) {
            return $prefix . $browser;
        }

        if (empty($browser) && empty($os) && !empty($device)) {
            return $prefix . $this->a($device);
        }

        if ($this->device->type == 'desktop' && !empty($os) && !empty($engine) && empty($device)) {
            return 'an unknown browser based on ' . $engine . ' running on ' . $os;
        }

        if ($this->browser->stock && !empty($os) && empty($device)) {
            return $os;
        }

        if ($this->browser->stock && !empty($engine) && empty($device)) {
            return 'an unknown browser based on ' . $engine;
        }
        
        if ($this->device->type == 'bot') {
            return 'an unknown bot';
        }

        return 'an unknown browser';
    }


    /**
     * Get a string containing a JavaScript representation of the object
     *
     * @return string
     */

    public function toJavaScript()
    {
        return "this.browser = new Browser({ " . $this->browser->toJavaScript() . " });\n" .
               "this.engine = new Engine({ " . $this->engine->toJavaScript() . " });\n" .
               "this.os = new Os({ " . $this->os->toJavaScript() . " });\n" .
               "this.device = new Device({ " . $this->device->toJavaScript() . " });\n" .
               "this.camouflage = " . ($this->camouflage ? 'true' : 'false') . ";\n" .
               "this.features = " . json_encode($this->features) . ";\n";
    }


    /**
     * Get an array of all defined properties
     *
     * @return array
     */

    public function toArray()
    {
        $result = [
            'browser'   => $this->browser->toArray(),
            'engine'    => $this->engine->toArray(),
            'os'        => $this->os->toArray(),
            'device'    => $this->device->toArray()
        ];

        if (empty($result['browser'])) {
            unset($result['browser']);
        }

        if (empty($result['engine'])) {
            unset($result['engine']);
        }

        if (empty($result['os'])) {
            unset($result['os']);
        }

        if (empty($result['device'])) {
            unset($result['device']);
        }

        if ($this->camouflage) {
            $result['camouflage'] = true;
        }

        return $result;
    }
}
