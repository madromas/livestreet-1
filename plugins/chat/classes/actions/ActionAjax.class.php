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

class PluginChat_ActionAjax extends ActionPlugin
{

    protected $oUserCurrent = null;

    public function Init()
    {
        $this->Viewer_SetResponseAjax('json');
        $this->oUserCurrent = $this->User_GetUserCurrent();
    }

    protected function RegisterEvent()
    {
        $this->AddEvent('getlist', 'GetList');
        $this->AddEvent('add', 'Add');
    }

    protected function Add()
    {
        if (!$this->oUserCurrent) {
            $this->Message_AddError($this->Lang_Get('not_access'), $this->Lang_Get('error'));
            return false;
        }

        if (!func_check(getRequest('text', null, 'post'), 'text', 0, Config::Get('plugin.chat.max_length'))) {
            $this->Message_AddError($this->Lang_Get('plugin.chat.error_text', array('LENGHT' => Config::Get('plugin.chat.max_length'))), $this->Lang_Get('error'));
            return false;
        }

        $sText = getRequest('text');

        if ($this->PluginChat_Chat_Add(array('login' => $this->oUserCurrent->getLogin(), 'id' => $this->oUserCurrent->getId(), 'text' => $this->Text_Parser($sText)))) {

        } else {
            $this->Message_AddError($this->Lang_Get('system_error'), $this->Lang_Get('error'));
        }
    }

    protected function GetList()
    {
        // В зависимости от типа загрузчика устанавливается тип ответа
        if (getRequest('is_iframe')) {
            $this->Viewer_SetResponseAjax('jsonIframe', false);
        } else {
            $this->Viewer_SetResponseAjax('json');
        }

        /**
         * Проверяем авторизован ли юзер
         */
        if (!$this->User_IsAuthorization()) {
            $this->Message_AddErrorSingle($this->Lang_Get('not_access'), $this->Lang_Get('error'));
            return Router::Action('error');
        }

        $aList = $this->PluginChat_Chat_GetList(Config::Get('plugin.chat.pop_per_page'));
        $this->Viewer_AssignAjax('aList', $aList);
    }

}

?>
