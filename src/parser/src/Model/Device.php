<?php

namespace WhichBrowser\Model;

use WhichBrowser\Constants;
use WhichBrowser\Model\Primitive\Base;

class Device extends Base
{
    /** @var string */
    public $manufacturer;

    /** @var string */
    public $model;

    /** @var string */
    public $series;

    /** @var int */
    public $identifier;


    /** @var string */
    public $type = '';

    /** @var string */
    public $subtype = '';

    /** @var int */
    public $identified = Constants\Id::NONE;

    /** @var boolean */
    public $generic = true;


    /**
     * Set the properties to the default values
     *
     * @internal
     */

    public function reset()
    {
        unset($this->manufacturer);
        unset($this->model);
        unset($this->series);
        unset($this->identifier);

        $this->type = '';
        $this->subtype = '';
        $this->identified = Constants\Id::NONE;
        $this->generic = true;
    }


    /**
     * Get the name of the manufacturer in a human readable format
     *
     * @return string
     */

    public function getManufacturer()
    {
        return $this->identified && !empty($this->manufacturer) ? $this->manufacturer : '';
    }


    /**
     * Get the name of the model in a human readable format
     *
     * @return string
     */

    public function getModel()
    {
        if ($this->identified) {
            return trim((!empty($this->model) ? $this->model . ' ' : '') . (!empty($this->series) ? $this->series : ''));
        }

        return !empty($this->model) ? $this->model : '';
    }


    /**
     * Get the combined name of the manufacturer and model in a human readable format
     *
     * @return string
     */

    public function toString()
    {
        if ($this->identified) {
            $model = $this->getModel();
            $manufacturer = $this->getManufacturer();

            if ($manufacturer != '' && strpos($model, $manufacturer) === 0) {
                $manufacturer = '';
            }

            return trim($manufacturer . ' ' . $model);
        }

        return !empty($this->model) ? 'unrecognized device (' . $this->model . ')' : '';
    }


    /**
     * Check if device information is detected
     *
     * @return boolean
     */

    public function isDetected()
    {
        return !empty($this->type) || !empty($this->model) || !empty($this->manufacturer);
    }


    /**
     * Get an array of all defined properties
     *
     * @internal
     *
     * @return array
     */

    public function toArray()
    {
        $result = [];

        if (!empty($this->type)) {
            $result['type'] = $this->type;
        }
        
        if (!empty($this->subtype)) {
            $result['subtype'] = $this->subtype;
        }

        if (!empty($this->manufacturer)) {
            $result['manufacturer'] = $this->manufacturer;
        }

        if (!empty($this->model)) {
            $result['model'] = $this->model;
        }

        if (!empty($this->series)) {
            $result['series'] = $this->series;
        }

        return $result;
    }
}
