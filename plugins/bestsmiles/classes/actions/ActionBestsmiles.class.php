<?php
/*
Автор - Grigory Smirnov
copyright 2014.
gs.dafter.ru
*/
class PluginBestsmiles_ActionBestsmiles extends ActionPlugin {
	
	public function Init() {
		$this->SetDefaultEvent('list');
	}
	
	protected function RegisterEvent() {
		$this->AddEvent('list', 'showSmiles');
	}
	
	//передаем массив смайликов
	protected function showSmiles(){
		$this->Viewer_AssignAjax('aSmiles', Config::Get('plugin.bestsmiles.smiles'));
		$this->Viewer_DisplayAjax('json');
	}

	public function EventShutdown() {

	}
}
?>