<?php

namespace WhichBrowser\Data;

use WhichBrowser\Constants\DeviceType;
use WhichBrowser\Constants\DeviceSubType;

DeviceModels::$PALMOS_MODELS = [
    'Palm-D061'                             => [ 'Palm', 'Centro', DeviceType::MOBILE ],
    'Palm-D062'                             => [ 'Palm', 'Centro', DeviceType::MOBILE ],
    'Palm-TunX'                             => [ 'Palm', 'LifeDrive', DeviceType::PDA ],
    'Palm-stuj'                             => [ 'Palm', 'm125', DeviceType::PDA ],
    'Palm-hbbs'                             => [ 'Palm', 'm130', DeviceType::PDA ],
    'Palm-trnd'                             => [ 'Palm', 'm500', DeviceType::PDA ],
    'Palm-ecty'                             => [ 'Palm', 'm505', DeviceType::PDA ],
    'Palm-lith'                             => [ 'Palm', 'm515', DeviceType::PDA ],
    'Palm-sky1'                             => [ 'Palm', 'i705', DeviceType::PDA ],
    'hspr-H101'                             => [ 'Palm', 'Treo 600', DeviceType::MOBILE ],
    'hspr-H102'                             => [ 'Palm', 'Treo 650', DeviceType::MOBILE ],
    'Palm-D053'                             => [ 'Palm', 'Treo 680', DeviceType::MOBILE ],
    'Palm-D052'                             => [ 'Palm', 'Treo 700', DeviceType::MOBILE ],
    'Palm-D060'                             => [ 'Palm', 'Treo 755', DeviceType::MOBILE ],
    'Palm-MT64'                             => [ 'Palm', 'Tungsten C', DeviceType::PDA ],
    'Palm-Cct1'                             => [ 'Palm', 'Tungsten E', DeviceType::PDA ],
    'Palm-Zir4'                             => [ 'Palm', 'Tungsten E2', DeviceType::PDA ],
    'Palm-Frg1'                             => [ 'Palm', 'Tungsten T', DeviceType::PDA ],
    'Palm-Frg2'                             => [ 'Palm', 'Tungsten T2', DeviceType::PDA ],
    'Palm-Arz1'                             => [ 'Palm', 'Tungsten T3', DeviceType::PDA ],
    'Palm-TnT5'                             => [ 'Palm', 'Tungsten T5', DeviceType::PDA ],
    'Palm-atc1'                             => [ 'Palm', 'Tungsten W', DeviceType::PDA ],
    'Palm-D050'                             => [ 'Palm', 'TX', DeviceType::PDA ],
    'Palm-Zi21'                             => [ 'Palm', 'Zire 21', DeviceType::PDA ],
    'Palm-D051'                             => [ 'Palm', 'Zire 22', DeviceType::PDA ],
    'Palm-Zi22'                             => [ 'Palm', 'Zire 31', DeviceType::PDA ],
    'Palm-Zpth'                             => [ 'Palm', 'Zire 71', DeviceType::PDA ],
    'Palm-Zi72'                             => [ 'Palm', 'Zire 72', DeviceType::PDA ],

    'sony-atom'                             => [ 'Sony', 'CLIÉ PEG-TH55', DeviceType::PDA ],
    'sony-prmr'                             => [ 'Sony', 'CLIÉ PEG-UX50', DeviceType::PDA ],
    'sony-tldo'                             => [ 'Sony', 'CLIÉ PEG-NX73V', DeviceType::PDA ],
    'sony-mdna'                             => [ 'Sony', 'CLIÉ PEG-T615C', DeviceType::PDA ],
    'sony-mdrd'                             => [ 'Sony', 'CLIÉ PEG-NX80V', DeviceType::PDA ],
    'sony-vrna'                             => [ 'Sony', 'CLIÉ PEG-TG50', DeviceType::PDA ],
    'sony-crdb'                             => [ 'Sony', 'CLIÉ PEG-NX60', DeviceType::PDA ],
    'sony-mcnd'                             => [ 'Sony', 'CLIÉ PEG-SJ33', DeviceType::PDA ],
    'sony-glps'                             => [ 'Sony', 'CLIÉ PEG-SJ22', DeviceType::PDA ],
    'sony-goku'                             => [ 'Sony', 'CLIÉ PEG-TJ35', DeviceType::PDA ],
    'sony-luke'                             => [ 'Sony', 'CLIÉ PEG-TJ37', DeviceType::PDA ],
    'sony-ystn'                             => [ 'Sony', 'CLIÉ PEG-N610C', DeviceType::PDA ],
    'sony-rdwd'                             => [ 'Sony', 'CLIÉ PEG-NR70', DeviceType::PDA ],
    'sony-leia'                             => [ 'Sony', 'CLIÉ PEG-TJ27', DeviceType::PDA ],

    'smsn-phix'                             => [ 'Samsung', 'SPH-i300', DeviceType::MOBILE ],
    'smsn-Phx2'                             => [ 'Samsung', 'SPH-i330', DeviceType::MOBILE ],
    'smsn-blch'                             => [ 'Samsung', 'SPH-i500', DeviceType::MOBILE ],

    'grmn-3200'                             => [ 'Garmin', 'iQue 3200', DeviceType::GPS ],
    'grmn-3600'                             => [ 'Garmin', 'iQue 3600', DeviceType::GPS ],
    'grmn-3700'                             => [ 'Garmin', 'iQue 3700', DeviceType::GPS ],

    'trgp-trg1'                             => [ 'HandEra', 'TRG Pro', DeviceType::PDA ],
    'trgp-trg2'                             => [ 'HandEra', '330', DeviceType::PDA ],

    'qcom-qc20'                             => [ 'Kyocera', 'QCP-6035', DeviceType::MOBILE ],
    'kwc.-7135'                             => [ 'Kyocera', 'QCP-7135', DeviceType::MOBILE ],

    'Tpwv-Rdog'                             => [ 'Tapwave', 'Zodiac', [ DeviceType::GAMING, DeviceSubType::PORTABLE ] ],

    'gsRl-zicn'                             => [ 'Group Sense', 'Xplore G18', DeviceType::MOBILE ],
];
