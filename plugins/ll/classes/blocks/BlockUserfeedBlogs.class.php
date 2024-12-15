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
 * Блок настройки списка блогов в ленте
 *
 */
class PluginLl_BlockUserfeedBlogs extends Block
{

    public function Exec()
    {
        if ($oUserCurrent = $this->User_getUserCurrent()) {
            /**
             * Получаем список блогов
             */
            $aResult = $this->PluginLl_Ll_GetBlogsAlphSort();
            /**
             * Получаем список подписок пользователя
             */
            $aUserSubscribes = $this->Userfeed_getUserSubscribes($oUserCurrent->getId());
            $aBlogs = $aResult['collection'];

            /**
             * Загружаем все в шаблон
             */
            $this->Viewer_Assign('aUserfeedSubscribedBlogs', $aUserSubscribes['blogs']);
            $this->Viewer_Assign('aBlogs', $aBlogs);
            $this->Viewer_Assign('iCount', $aResult['count']);
        }
    }

}