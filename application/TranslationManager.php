<?php

class TranslationManager
{
    protected function _init($settings, $zendLocale)
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
