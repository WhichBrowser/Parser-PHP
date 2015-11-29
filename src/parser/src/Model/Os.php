<?php

namespace WhichBrowser\Model;

use WhichBrowser\Model\Primitive\NameVersion;

class Os extends NameVersion
{
    /** @var string */
    public $family;


    /**
     * Set the properties to the default values
     */

    public function reset()
    {
        parent::reset();

        unset($this->family);
    }


    /**
     * Get an array of all defined properties
     *
     * @return array
     */

    public function toArray()
    {
        $result = [];

        if (!empty($this->name)) {
            $result['name'] = $this->name;
        }

        if (!empty($this->family)) {
            $result['family'] = $this->family->toArray();
        }

        if (!empty($this->alias)) {
            $result['alias'] = $this->alias;
        }

        if (!empty($this->version)) {
            $result['version'] = $this->version->toArray();
        }


        if (isset($result['name']) && empty($result['name'])) {
            unset($result['name']);
        }

        if (isset($result['version']) && !count($result['version'])) {
            unset($result['version']);
        }

        return $result;
    }
}
