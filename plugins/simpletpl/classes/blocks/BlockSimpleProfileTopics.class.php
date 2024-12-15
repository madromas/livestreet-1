<?php
/*-------------------------------------------------------
*
*   LiveStreet Engine Social Networking
*   Copyright © 2008 Mzhelskiy Maxim
*
*--------------------------------------------------------
*
*   Official site: www.livestreet.ru
*   Contact e-mail: rus.engine@gmail.com
*
*   GNU General Public License, version 2:
*   http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
*
---------------------------------------------------------
*/

/**
 * Обработка топиков в профиле пользователя
 *
 */
class PluginSimpletpl_BlockSimpleProfileTopics extends Block {
	public function Exec() {
		if ($oUser=$this->GetParam('user')) {
			$aResult=$this->Topic_GetTopicsPersonalByUser($oUser->getId(),1,1,Config::Get('plugin.simpletpl.count_profile_topics'));
			$this->Viewer_Assign('simpletpl_aTopicsProfile',$aResult['collection']);
		}
	}
}
?>