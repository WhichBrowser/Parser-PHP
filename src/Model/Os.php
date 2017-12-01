<?php

namespace WhichBrowser\Model;

use WhichBrowser\Model\Primitive\NameVersion;

class Os extends NameVersion
{
    /**
     * @var \WhichBrowser\Model\Family      $family     To which family does this operating system belong
     */
    public $family;

    /** @var string */
    public $edition;

    /** @var boolean */
    public $hidden = false;


    /**
     * Set the properties to the default values
     *
     * @param   array|null  $properties  An optional array of properties to set after setting it to the default values
     *
     * @internal
     */

    public function reset($properties = null)
    {
        parent::reset();

        unset($this->family);
        unset($this->edition);

        $this->hidden = false;

        if (is_array($properties)) {
            $this->set($properties);
        }
    }


    /**
     * Return the name of the operating system family
     *
     * @return string
     */

    public function getFamily()
    {
        if (isset($this->family)) {
            return $this->family->getName();
        }

        return $this->getName();
    }


    /**
     * Is the operating from the specified family
     *
     * @param  string   $name   The name of the family
     *
     * @return boolean
     */

    public function isFamily($name)
    {
        if ($this->getName() == $name) {
            return true;
        }

        if (isset($this->family)) {
            if ($this->family->getName() == $name) {
                return true;
            }
        }

        return false;
    }


    /**
     * Get the name and version in a human readable format
     *
     * @return string
     */

    public function toString()
    {
        if ($this->hidden) {
            return '';
        }
        
        return trim($this->getName() .
            (!empty($this->version) && !$this->version->hidden ? ' ' . $this->getVersion() : '')) .
            (!empty($this->edition) ? ' ' . $this->edition : '');
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

        if (!empty($this->name)) {
            $result['name'] = $this->name;
        }

        if (!empty($this->family)) {
            $result['family'] = $this->family->toArray();
        }

        if (!empty($this->alias)) {
            $result['alias'] = $this->alias;
        }

        if (!empty($this->edition)) {
            $result['edition'] = $this->edition;
        }

        if (!empty($this->version)) {
            $result['version'] = $this->version->toArray();
        }

        if (isset($result['version']) && empty($result['version'])) {
            unset($result['version']);
        }

        return $result;
    }
}
