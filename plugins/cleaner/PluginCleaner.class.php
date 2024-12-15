<?php

/*
    -------------------------------------------------------
*
*   LiveStreet (v.1.x)
*   Plugin Cleaner (v.0.9)
*   Copyright © 2013 Bishovec Nikolay
*
    --------------------------------------------------------
*
*   Plugin Page: http://netlanc.net
*   Contact e-mail: netlanc@yandex.ru
*
    ---------------------------------------------------------
*/

if (!class_exists('Plugin')) {
    die('Hacking attemp!');
}

class PluginCleaner extends Plugin
{
    protected $aInherits = array(
        'action' => array('ActionAdmin'),
    );

    public function Activate()
    {
        return true;
    }

    public function Init()
    {
        $this->Viewer_Assign('sTWCleaner', rtrim(Plugin::GetTemplateWebPath('cleaner'), '/'));
        $this->Viewer_AppendStyle(Plugin::GetTemplateWebPath('cleaner') . 'css/style.css');
    }

}

?>
