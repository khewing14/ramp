<?php

/**
 * RAMP: Records and Activity Management Program
 *
 * LICENSE
 *
 * This source file is subject to the BSD-2-Clause license that is bundled
 * with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://www.cs.kzoo.edu/ramp/LICENSE.txt
 *
 * @category   Ramp
 * @package    Ramp
 * @copyright  Copyright (c) 2013 Alyce Brady (http://www.cs.kzoo.edu/~abrady)
 * @license    http://www.cs.kzoo.edu/ramp/LICENSE.txt   Simplified BSD License
 *
 */

class TranslationManager
{
    // Public instance variables
    public $settings;
    public $locale;

    /**
    * Constructor for TranslationManager class. Sets a settings object and
    * a Zend_Locale object.
    *
    * @param array => settings
    * @param object => ZendLocale object to be set
    *
    */
    public function __construct($settings, $zendLocale)
    {
        $this->settings = $settings;
        $this->locale = $zendLocale;
    }

    /**
    * Takes an array or string and gives back the path to the current file taking
    * translation into account.
    *
    * Array Example: $translator->getFilePath(["somepath", "anotherpath", "thirdpath"])
    * Returns => ["somepath/en", "anotherpath/en", "thirdpath/en"]
    *
    * String Example: $translator->getFilePath("somepath")
    * Returns => ["somepath/en"]
    *
    * @param (array || string) => (array of) string(s) representing path(s) to be "internationalized"
    * @return (array || string) => (array of) string(s) representing the path to the new translated file
    *
    */
    public function getFilePath($key)
    {
        $val = $this->settings[$key];
        if (gettype($val) == "string")
        {
            $temp = $this->translatePath($val);
            return $this->translatePath($val);
        }
        if (gettype($val) == "array")
        {
            $ret = array();
            foreach ($val as $path)
            {
                array_push($ret, $this->translatePath($path));
            }
            return $ret;
        }
    }

    /**
    * Takes a string path and returns an "internationalized" path.
    * The internationalized path contains the original path with the
    * current locale appended to the end.
    *
    * Example: $this->translatePath('somepath') => somepath/en
    *
    * @param string => path to be "internationalized"
    * @return string => internationalized path
    *
    */
    private function translatePath($path) {
        return $path . "/" . $this->locale->getLanguage();
    }
}

?>
