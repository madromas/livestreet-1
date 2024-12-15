<?php
/*---------------------------------------------------------------------------------------
 *	author: Artemev Yurii
 *	LiveStreet version: 0.4.2
 *	plugin: LsPage
 *	version: 1.3
 *	Author site: http://epiclab.ru/
 *	license: GNU GPL v2, http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 *--------------------------------------------------------------------------------------*/

if (!class_exists('Plugin')) {
	die('Hacking attemp!');
}

class PluginLspage extends Plugin {

        /**
         * Активация плагина
         */
        public function Activate() {
                return true;
        }
		
		protected $aDelegates = array(
			'template' => array( 'paging.tpl' => '_paging.tpl' )
		);
        
        /**
         * Инициализация плагина
         */
        public function Init() {
		
			$this->Viewer_AppendStyle(Plugin::GetTemplateWebPath(__CLASS__).'css/LsPage.css');
		
			$this->Viewer_AppendScript(Plugin::GetTemplateWebPath(__CLASS__).'js/LsPage.js');

        }
        
        /**
         * Деактивация плагина
         */
        public function Deactivate() {
                return true;
        }
}
