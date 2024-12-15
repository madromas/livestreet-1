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

/**
 * Блок настройки списка пользователей в ленте
 *
 */
class PluginLl_BlockUserfeedUsers extends Block
{
    public function Exec()
    {
        if ($oUserCurrent = $this->User_getUserCurrent()) {
            $aUserSubscribes = $this->Userfeed_getUserSubscribes($oUserCurrent->getId());
            $aFriends = $this->User_getUsersFriend($oUserCurrent->getId());

            $this->Viewer_Assign('aUserfeedSubscribedUsers', $aUserSubscribes['users']);
            $this->Viewer_Assign('aUserfeedFriends', $aFriends['collection']);
        }
    }
}