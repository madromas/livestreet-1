<?php
/*-------------------------------------------------------
*
*   BlockTop Plugin
*   Copyright 2011 Uladzimir Kulesh
*   Contact e-mail: v.a.kulesh@ya.ru
*
*--------------------------------------------------------
*/


class PluginBlocktop_BlockTop extends Block {

	public function Exec() {
		
		/**
		 * Определяем период ТОПа
		 */
		$iTimeDelta=60*60*24*Config::Get('plugin.blocktop.topic_top');
		
		$sDate=date("Y-m-d H:00:00",time()-$iTimeDelta);
		
		/**
		 * Получаем список топиков
		 */			
		$aTopTopics=$this->Topic_GetTopicsRatingByDate($sDate,Config::Get('plugin.blocktop.topic_count'));

		/**
		 * Загружаем переменные в шаблон
		 */		
		$this->Viewer_Assign('aTopTopics',$aTopTopics);
		
	}

}
?>