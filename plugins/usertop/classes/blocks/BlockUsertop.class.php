<?php
/*-------------------------------------------------------
*
*   UserTop Plugin
*   Copyright 2011 Uladzimir Kulesh
*   Contact e-mail: v.a.kulesh@ya.ru
*
*--------------------------------------------------------
*/

class PluginUsertop_BlockUsertop extends Block {

	public function Exec() {
		/**
		 * По какому полю сортировать
		 */
		$sOrder='user_rating';
		if (getRequest('order')) {
			$sOrder=(string)getRequest('order');
		}
		/**
		 * В каком направлении сортировать
		 */
		$sOrderWay='desc';
		if (getRequest('order_way')) {
			$sOrderWay=(string)getRequest('order_way');
		}
		$aFilter=array(
			'activate' => 1
		);
		/**
		 * Получаем список юзеров
		 */
		$aResult=$this->User_GetUsersByFilter($aFilter,array($sOrder=>$sOrderWay),1,Config::Get('plugin.usertop.user_count'));
		$aUsertop=$aResult['collection'];
		/**
		 * Загружаем переменные в шаблон
		 */
		$this->Viewer_Assign('aUsertop',$aUsertop);
	}	
	
}
?>