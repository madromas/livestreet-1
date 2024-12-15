<?php
/* -------------------------------------------------------
 *
 *   LiveStreet (1.x)
 *   Plugin Chat (free) (v.0.1)
 *   Copyright В© 2013 Bishovec Nikolay
 *
 * --------------------------------------------------------
 *
 *   Plugin Page: http://netlanc.net
 *   Contact e-mail: netlanc@yandex.ru
 *
 * ---------------------------------------------------------
 */

/**
 * Модуль чата
 *
 */
class PluginChat_ModuleChat extends Module
{
    protected $oMapper;

    /**
     * Инициализация
     *
     */
    public function Init()
    {
        $this->oMapper = Engine::GetMapper(__CLASS__);
    }

    public function Add($aData)
    {
        if ($sId = $this->oMapper->Add($aData)){
            if (!Config::Get('plugin.chat.history_store')){
                $this->oMapper->DeleteHistory();
            }
            return $sId;
        }
        return false;
    }

    public function GetList($iLimit)
    {
        return $this->oMapper->GetList($iLimit);
    }

}

?>