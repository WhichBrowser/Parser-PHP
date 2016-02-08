<?php

namespace WhichBrowser\Data;

use WhichBrowser\Constants\DeviceType;
use WhichBrowser\Constants\DeviceSubType;

DeviceModels::$PALMOS_MODELS = [
    'Palm-D061'                             => [ 'Palm', 'Centro 685', DeviceType::MOBILE ],
    'Palm-D062'                             => [ 'Palm', 'Centro 690', DeviceType::MOBILE ],
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
    'Palm-Cubs'                             => [ 'Palm', 'Zire', DeviceType::PDA ],
    'Palm-Zi21'                             => [ 'Palm', 'Zire 21', DeviceType::PDA ],
    'Palm-D051'                             => [ 'Palm', 'Zire 22', DeviceType::PDA ],
    'Palm-Zi22'                             => [ 'Palm', 'Zire 31', DeviceType::PDA ],
    'Palm-Zpth'                             => [ 'Palm', 'Zire 71', DeviceType::PDA ],
    'Palm-Zi72'                             => [ 'Palm', 'Zire 72', DeviceType::PDA ],

    'sony-ystn'                             => [ 'Sony', 'CLIÉ PEG-N600C', DeviceType::PDA ],
    'sony-ysmt'                             => [ 'Sony', 'CLIÉ PEG-N700C', DeviceType::PDA ],
    'sony-ysm2'                             => [ 'Sony', 'CLIÉ PEG-N750C', DeviceType::PDA ],
    'sony-nsca'                             => [ 'Sony', 'CLIÉ PEG-S320', DeviceType::PDA ],
    'sony-nsc2'                             => [ 'Sony', 'CLIÉ PEG-S360', DeviceType::PDA ],
    'sony-vnce'                             => [ 'Sony', 'CLIÉ PEG-T400', DeviceType::PDA ],
    'sony-mdna'                             => [ 'Sony', 'CLIÉ PEG-T600C', DeviceType::PDA ],
    'sony-npls'                             => [ 'Sony', 'CLIÉ PEG-T650C', DeviceType::PDA ],
    'sony-rdwd'                             => [ 'Sony', 'CLIÉ PEG-NR70', DeviceType::PDA ],
    'sony-crdb'                             => [ 'Sony', 'CLIÉ PEG-NX60', DeviceType::PDA ],
    'sony-tldo'                             => [ 'Sony', 'CLIÉ PEG-NX73V', DeviceType::PDA ],
    'sony-mdrd'                             => [ 'Sony', 'CLIÉ PEG-NX80V', DeviceType::PDA ],
    'sony-grnd'                             => [ 'Sony', 'CLIÉ PEG-NZ90', DeviceType::PDA ],
    'sony-frta'                             => [ 'Sony', 'CLIÉ PEG-SL10', DeviceType::PDA ],
    'sony-cocs'                             => [ 'Sony', 'CLIÉ PEG-SL20', DeviceType::PDA ],
    'sony-glps'                             => [ 'Sony', 'CLIÉ PEG-SJ22', DeviceType::PDA ],
    'sony-mcnd'                             => [ 'Sony', 'CLIÉ PEG-SJ33', DeviceType::PDA ],
    'sony-vrna'                             => [ 'Sony', 'CLIÉ PEG-TG50', DeviceType::PDA ],
    'sony-atom'                             => [ 'Sony', 'CLIÉ PEG-TH55', DeviceType::PDA ],
    'sony-goha'                             => [ 'Sony', 'CLIÉ PEG-TJ25', DeviceType::PDA ],
    'sony-leia'                             => [ 'Sony', 'CLIÉ PEG-TJ27', DeviceType::PDA ],
    'sony-hwai'                             => [ 'Sony', 'CLIÉ PEG-TJ30', DeviceType::PDA ],
    'sony-goku'                             => [ 'Sony', 'CLIÉ PEG-TJ35', DeviceType::PDA ],
    'sony-luke'                             => [ 'Sony', 'CLIÉ PEG-TJ37', DeviceType::PDA ],
    'sony-amno'                             => [ 'Sony', 'CLIÉ PEG-UX40', DeviceType::PDA ],
    'sony-prmr'                             => [ 'Sony', 'CLIÉ PEG-UX50', DeviceType::PDA ],
    'sony-ancy'                             => [ 'Sony', 'CLIÉ PEG-VZ90', DeviceType::PDA ],

    'smsn-phix'                             => [ 'Samsung', 'SPH-i300', DeviceType::MOBILE ],
    'smsn-Phx2'                             => [ 'Samsung', 'SPH-i330', DeviceType::MOBILE ],
    'smsn-blch'                             => [ 'Samsung', 'SPH-i500', DeviceType::MOBILE ],
    'smsn-BLFM'                             => [ 'Samsung', 'SPH-i530', DeviceType::MOBILE ],
    'smsn-glxy'                             => [ 'Samsung', 'SPH-i550', DeviceType::MOBILE ],

    'grmn-3200'                             => [ 'Garmin', 'iQue 3200', DeviceType::GPS ],
    'grmn-3600'                             => [ 'Garmin', 'iQue 3600', DeviceType::GPS ],
    'grmn-3700'                             => [ 'Garmin', 'iQue 3600a', DeviceType::GPS ],

    'trgp-trg1'                             => [ 'HandEra', 'TRG Pro', DeviceType::PDA ],
    'trgp-trg2'                             => [ 'HandEra', '330', DeviceType::PDA ],

    'qcom-qc20'                             => [ 'Kyocera', 'QCP-6035', DeviceType::MOBILE ],
    'kwc.-7135'                             => [ 'Kyocera', 'QCP-7135', DeviceType::MOBILE ],

    'Tpwv-Rdog'                             => [ 'Tapwave', 'Zodiac', [ DeviceType::GAMING, DeviceSubType::PORTABLE ] ],

    'gsRl-zicn'                             => [ 'Group Sense', 'Xplore G18', DeviceType::MOBILE ],
    'gsRl-zcn2'                             => [ 'Group Sense', 'Xplore M28', DeviceType::MOBILE ],
    'gsRl-zcn5'                             => [ 'Group Sense', 'Xplore M68', DeviceType::MOBILE ],

    'acer-momo'                             => [ 'Acer', 's10', DeviceType::PDA ],
    'acer-coco'                             => [ 'Acer', 's50', DeviceType::PDA ],

    'Acea-MZ01'                             => [ 'Aceeca', 'Meazura MEZ1000', DeviceType::PDA ],
    'Acea-PD01'                             => [ 'Aceeca', 'PDA32', DeviceType::PDA ],
];
