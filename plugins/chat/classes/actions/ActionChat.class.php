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

class PluginChat_ActionChat extends ActionPlugin
{

    protected $oUserCurrent = null;

    public function Init()
    {
        $this->oUserCurrent = $this->User_GetUserCurrent();
        $this->SetDefaultEvent('index');
    }

    protected function RegisterEvent()
    {
        $this->AddEvent('index', 'EventIndex');
    }

    protected function EventIndex()
    {
        if (!$this->oUserCurrent or !$this->oUserCurrent->isAdministrator()) {
            return Router::Action('error', '404');
        }
        $this->SetTemplateAction('index');
    }

    public function EventShutdown()
    {

    }
}

?>
