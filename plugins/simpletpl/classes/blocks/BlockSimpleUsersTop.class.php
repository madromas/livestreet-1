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
 * Обработка блока с популярными пользователями на главной странице
 *
 */
class PluginSimpletpl_BlockSimpleUsersTop extends Block {
	public function Exec() {
		$aResult=$this->User_GetUsersByFilter(array('user_activate'=>1),array('user_rating'=>'desc'),1,Config::Get('plugin.simpletpl.count_top_users'));

		$this->Viewer_Assign('simpletpl_aUsersTop',$aResult['collection']);
	}
}
?>