<?php

namespace WhichBrowser\Model\Primitive;

/**
 * @internal
 */

class Base
{
    /**
     * Set the properties of the object the the values specified in the array
     *
     * @param  array|null   An array, the key of an element determines the name of the property
     */
    public function __construct($defaults = null)
    {
        if (is_array($defaults)) {
            $this->set($defaults);
        }
    }


    /**
     * Set the properties of the object the the values specified in the array
     *
     * @param  array  $properties  An array, the key of an element determines the name of the property
     *
     * @internal
     */
    public function set($properties)
    {
        foreach ($properties as $k => $v) {
            $this->{$k} = $v;
        }
    }


    /**
     * Get a string containing a JavaScript representation of the object
     *
     * @internal
     *
     * @return string
     */

    public function toJavaScript()
    {
        $lines = [];

        foreach (get_object_vars($this) as $key => $value) {
            if (!is_null($value)) {
                $line = $key . ": ";

                if ($key == 'version') {
                    $line .= 'new Version({ ' . $value->toJavaScript() . ' })';
                } elseif ($key == 'family') {
                    $line .= 'new Family({ ' . $value->toJavaScript() . ' })';
                } elseif ($key == 'using') {
                    $line .= 'new Using({ ' . $value->toJavaScript() . ' })';
                } else {
                    switch (gettype($value)) {
                        case 'boolean':
                            $line .= $value ? 'true' : 'false';
                            break;
                        case 'string':
                            $line .= '"' . addslashes($value) . '"';
                            break;
                        case 'integer':
                            $line .= $value;
                            break;
                    }
                }

                $lines[] = $line;
            }
        }

        return implode(", ", $lines);
    }
}
