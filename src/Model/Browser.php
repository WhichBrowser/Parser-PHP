<?php

namespace WhichBrowser\Model;

use WhichBrowser\Model\Primitive\NameVersion;

class Browser extends NameVersion
{
    /**
     * @var \WhichBrowser\Model\Using       $using      Information about web views the browser is using
     * @var \WhichBrowser\Model\Family      $family     To which browser family does this browser belong
     */
    public $using;
    public $family;


    /** @var string */
    public $channel;

    /** @var boolean */
    public $stock = true;

    /** @var boolean */
    public $hidden = false;

    /** @var string */
    public $mode = '';

    /** @var string */
    public $type = '';


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

        unset($this->channel);
        unset($this->using);
        unset($this->family);

        $this->stock = true;
        $this->hidden = false;
        $this->mode = '';
        $this->type = '';

        if (is_array($properties)) {
            $this->set($properties);
        }
    }


    /**
     * Get the name in a human readable format
     *
     * @return string
     */

    public function getName()
    {
        $name = !empty($this->alias) ? $this->alias : (!empty($this->name) ? $this->name : '');
        return $name ? $name . (!empty($this->channel) ? ' ' . $this->channel : '') : '';
    }


    /**
     * Is the browser from the specified family
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
     * Is the browser using the specified webview
     *
     * @param  string   $name   The name of the webview
     *
     * @return boolean
     */

    public function isUsing($name)
    {
        if (isset($this->using)) {
            if ($this->using->getName() == $name) {
                return true;
            }
        }

        return false;
    }


    /**
     * Get a combined name and version number in a human readable format
     *
     * @return string
     */

    public function toString()
    {
        if ($this->hidden) {
            return '';
        }
        
        $result = trim($this->getName() . ' ' . (!empty($this->version) && !$this->version->hidden ? $this->getVersion() : ''));

        if (empty($result) && isset($this->using)) {
            return $this->using->toString();
        }

        return $result;
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

        if (!empty($this->alias)) {
            $result['alias'] = $this->alias;
        }

        if (!empty($this->using)) {
            $result['using'] = $this->using->toArray();
        }

        if (!empty($this->family)) {
            $result['family'] = $this->family->toArray();
        }

        if (!empty($this->version)) {
            $result['version'] = $this->version->toArray();
        }

        if (!empty($this->type)) {
            $result['type'] = $this->type;
        }

        if (isset($result['version']) && empty($result['version'])) {
            unset($result['version']);
        }

        return $result;
    }
}
