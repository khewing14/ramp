<?php

class TranslationManager
{

    public $settings;
    public $locale;

    public function __construct($settings, $zendLocale)
    {
        $this->settings = $settings;
        $this->locale = $zendLocale;
    }

    public function getFilePath($key)
    {
        $val = $this->settings[$key];
        if (gettype($val) == "string")
        {
            $this->translatePath($val);
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

    private function translatePath($path) {
        return $path . "/" . $this->locale->getLanguage() . ".ini";
    }
}

?>
