<?php
/*-------------------------------------------------------
*
*   BlockTop Plugin
*   Copyright 2011 Uladzimir Kulesh
*   Contact e-mail: v.a.kulesh@ya.ru
*
*--------------------------------------------------------
*/

if (!class_exists('Plugin')) {
    die('Hacking attemp!');
}

class PluginBlocktop extends Plugin {

	/**
	 * ��������� �������
	 */
    public function Activate() {
		return true;
    }
	
	/**
	 * ������������� �������
	 */
	public function Init() {
		$this->Viewer_AppendStyle(Plugin::GetTemplatePath('PluginBlocktop')."css/style.css"); // ���������� CSS
	}

}
?>