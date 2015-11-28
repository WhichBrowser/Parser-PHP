<?php

namespace WhichBrowser\Model\Primitive;

class NameVersion extends Base
{
    public $name;
    public $alias;
    public $version;


    public function reset()
    {
        unset($this->name);
        unset($this->alias);
        unset($this->version);
    }

    public function getName()
    {
        return !empty($this->alias) ? $this->alias : (!empty($this->name) ? $this->name : '');
    }

    public function getVersion()
    {
        return !empty($this->version) && !$this->version->hidden ? $this->version->toString() : '';
    }

    public function isDetected()
    {
        return !empty($this->name);
    }

    public function toString()
    {
        return trim($this->getName() . ' ' . $this->getVersion());
    }
}
