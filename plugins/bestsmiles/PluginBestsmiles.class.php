<?php
/*
Автор - Grigory Smirnov
copyright 2014.
gs.dafter.ru
*/

if(!class_exists('Plugin')){
	die('Hacking!');
}

class PluginBestsmiles extends Plugin {
	public function Activate() {
		$this->sendStat();
		return true;
	}

	public function Deactivate() {
		$this->sendStat('off');
		return true;
	}
	
	public function Init() {
	}

	//Если вы не хотите, чтобы один раз отправилась статистика только лишь с именем сайта, то закомментируйте код функции
	private function sendStat($act = 'on') {
		$url = @fopen("http://gs.dafter.ru/plugstat.php?n=bestsmiles&a=".$act."&s=".$_SERVER['HTTP_HOST'], "r");
		@fclose($url);
	}
}
?>