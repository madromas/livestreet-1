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

class PluginLl_ActionUserfeed extends PluginLl_Inherit_ActionUserfeed
{

    /**
     * Завергаем экшен
     *
     */
    public function EventShutdown()
    {
        /**
         * При условии что пользователь авторизован и передан параметр feed собираем стат данные для меню
         *
         */
        if ($oUserCurrent = $this->User_GetUserCurrent() and Router::GetParam(0) == 'feed') {
            $this->iCountTopicsCollectiveNew = $this->Topic_GetCountTopicsCollectiveNew();
            $this->iCountTopicsPersonalNew = $this->Topic_GetCountTopicsPersonalNew();
            $this->iCountTopicsNew = $this->iCountTopicsCollectiveNew + $this->iCountTopicsPersonalNew;
            $this->Viewer_Assign('sMenuHeadItemSelect', 'blog');
            $this->Viewer_Assign('sMenuItemSelect', 'index');
            $this->Viewer_Assign('sMenuSubItemSelect', 'good');
            $this->Viewer_Assign('iCountTopicsNew', $this->iCountTopicsNew);
            $this->Viewer_Assign('iCountTopicsCollectiveNew', $this->iCountTopicsCollectiveNew);
            $this->Viewer_Assign('iCountTopicsPersonalNew', $this->iCountTopicsPersonalNew);
        }
    }
}

?>
