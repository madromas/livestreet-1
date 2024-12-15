<?php
/*
Автор - Grigory Smirnov
copyright 2014.
gs.dafter.ru
*/
class PluginBestsmiles_HookSmile extends Hook {
	public function RegisterHook() {
		$this->AddHook('engine_init_complete','addFiles');
		$this->AddHook('template_html_head_end','addJs');
		$this->AddHook('template_body_begin', 'addTpl');
	}

	public function addFiles() {
		//добавляем css
		$this->Viewer_AppendStyle(Plugin::GetTemplatePath(__CLASS__).'css/bsmiles.css');
		//js
		$this->Viewer_AppendScript(Plugin::GetTemplatePath(__CLASS__).'js/bsmiles.js');
	}
	
	public function addJs(){
		return "<script>var BESTSMILES_TINYMCE = " . json_encode(Config::Get('view.tinymce')) . "; var BESTSMILES_TEMPLATE_PATH = " . json_encode(Plugin::GetTemplateWebPath(__CLASS__)) . ";</script>";
	}

	public function addTpl() {
		//tpl файл, где передаются значения конфига в js
		return $this->Viewer_Fetch(Plugin::GetTemplatePath(__CLASS__).'tplConf.tpl');
		
	}
	

}
?>