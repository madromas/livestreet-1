<?php

/* -------------------------------------------------------
 *
 *   LiveStreet (1.x)
 *   Plugin Live Lenta (v.0.2)
 *   Copyright © 2011 Bishovec Nikolay
 *
 * --------------------------------------------------------
 *
 *   Plugin Page: http://netlanc.net
 *   Contact e-mail: netlanc@yandex.ru
 *
  ---------------------------------------------------------
 */

class PluginLl_HookLl extends Hook
{

    public function RegisterHook()
    {
        $this->AddHook('init_action', 'InitAction', __CLASS__);
    }

    public function InitAction()
    {
        /**
         * Подмена главной страницы на страницу ленты при условии что пользовалель авторизован и хоть на чтото подписан
         *
         */
        if ($oUserCurrent = $this->User_GetUserCurrent() and Router::GetAction() == 'index') {
            if ($aUserSubscribes = $this->Userfeed_getUserSubscribes($oUserCurrent->getId())) {
                if (!empty($aUserSubscribes['blogs']) or !empty($aUserSubscribes['blogs'])) {
                    Router::SetParam(0, 'feed');
                    Router::Action('feed', 'index');
                }
            }
        }
    }
}

?>
