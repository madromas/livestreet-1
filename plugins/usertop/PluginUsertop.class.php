<?php
/*-------------------------------------------------------
*
*   UserTop Plugin
*   Copyright 2011 Uladzimir Kulesh
*   Contact e-mail: v.a.kulesh@ya.ru
*
*--------------------------------------------------------
*/

if (!class_exists('Plugin')) {
    die('Hacking attemp!');
}

class PluginUsertop extends Plugin {

	/**
	 * Активация плагина
	 */
    public function Activate() {
		return true;
    }
	
	/**
	 * Инициализация плагина
	 */
    public function Init() {
		$this->Viewer_AppendStyle(Plugin::GetTemplatePath('PluginUsertop')."/css/style.css"); // Добавление CSS
    }

}
?>