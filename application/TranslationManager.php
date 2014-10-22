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
        return $this->settings[$key] . "/" . $this->locale->getLanguage() . ".ini";
    } 
}

?>
