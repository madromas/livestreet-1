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

class PluginCleaner_ActionAdmin extends PluginCleaner_Inherit_ActionAdmin
{

    protected $sMenuItemSelect = 'cleaner';
    protected $oUserCurrent = null;

    /**
     * Инициализация плагина
     */
    public function Init()
    {
        parent:: Init();
    }

    /**
     * Регистрация евентов
     */
    protected function RegisterEvent()
    {
        parent:: RegisterEvent();
        $this->AddEvent('cleaner','EventCleaner');
        $this->AddEvent('cleaner-go','EventCleanerGo');
    }

    /**
     * Вывод страницы пылесоса
     */
    protected function EventCleaner()
    {

    }

    /**
     * Ручной запуск пылесоса
     */
    protected function EventCleanerGo()
    {
        $this->Viewer_SetResponseAjax('jsonIframe', false);

        $aParams = array();
        if (getRequest('images')){
            $aParams[] = 'images';
        }
        if (getRequest('comments')){
            $aParams[] = 'comments';
        }
        if (getRequest('counters')){
            $aParams[] = 'counters';
        }
        if (getRequest('relations')){
            $aParams[] = 'relations';
        }

        if ($this->PluginCleaner_Cleaner_Clean($aParams)){
            $this->Message_AddNoticeSingle($this->Lang_Get('plugin.cleaner.cleaner_attention_ok'), $this->Lang_Get('attention'));
        } else {
            $this->Message_AddNoticeSingle($this->Lang_Get('system_error'), $this->Lang_Get('attention'));
        }

        return;

    }

    /**
     * EventShutdown
     */
    public function EventShutdown()
    {
        $this->Viewer_Assign('sMenuItemSelect', $this->sMenuItemSelect);
    }

}

?>
