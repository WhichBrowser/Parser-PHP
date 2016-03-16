<?php

namespace WhichBrowser\Model\Primitive;

use WhichBrowser\Model\Version;

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
     * @param   array|null  $properties  An optional array of properties to set after setting it to the default values
     *
     * @internal
     */

    public function reset($properties = null)
    {
        unset($this->name);
        unset($this->alias);
        unset($this->version);

        if (is_array($properties)) {
            $this->set($properties);
        }
    }


    /**
     * Identify the version based on a pattern
     *
     * @param   string      $pattern   The regular expression that defines the group that matches the version string
     * @param   string      $subject   The string the regular expression is matched with
     * @param   array|null  $defaults  An optional array of properties to set together with the value
     *
     * @return string
     */

    public function identifyVersion($pattern, $subject, $defaults = [])
    {
        if (preg_match($pattern, $subject, $match)) {
            $version = $match[1];

            if (isset($defaults['type'])) {
                switch ($defaults['type']) {
                    case 'underscore':
                        $version = str_replace('_', '.', $version);
                        break;
                    case 'legacy':
                        $version = preg_replace("/([0-9])([0-9])/", '$1.$2', $version);
                        break;
                }
            }


            $this->version = new Version(array_merge($defaults, [ 'value' => $version ]));
        }
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
        return !empty($this->version) ? $this->version->toString() : '';
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
        return trim($this->getName() . ' ' . (!empty($this->version) && !$this->version->hidden ? $this->getVersion() : ''));
    }
}
