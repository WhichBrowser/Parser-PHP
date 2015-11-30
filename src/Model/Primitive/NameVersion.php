<?php

namespace WhichBrowser\Model\Primitive;

/**
 * @internal
 */

class NameVersion extends Base
{
    /**
     * @var string                          $name       The name
     * @var string                          $alias      An alternative name that is used for readable strings
     * @var \WhichBrowser\Model\Version     $version    Version information
     */
    public $name;
    public $alias;
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
