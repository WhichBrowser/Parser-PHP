<?php

namespace WhichBrowser\Model\Primitive;

class NameVersion extends Base
{
    /** @var string */
    public $name;

    /** @var string */
    public $alias;

    /** @var \WhichBrowser\Model\Browser */
    public $version;


    /**
     * Set the properties to the default values
     *
     * @internal
     */

    public function reset()
    {
        unset($this->name);
        unset($this->alias);
        unset($this->version);
    }


    /**
     * Get the name in a human readable format
     *
     * @return string
     */

    public function getName()
    {
        return !empty($this->alias) ? $this->alias : (!empty($this->name) ? $this->name : '');
    }


    /**
     * Get the version in a human readable format
     *
     * @return string
     */

    public function getVersion()
    {
        return !empty($this->version) && !$this->version->hidden ? $this->version->toString() : '';
    }


    /**
     * Is a name detected?
     *
     * @return boolean
     */

    public function isDetected()
    {
        return !empty($this->name);
    }


    /**
     * Get the name and version in a human readable format
     *
     * @return string
     */

    public function toString()
    {
        return trim($this->getName() . ' ' . $this->getVersion());
    }
}
