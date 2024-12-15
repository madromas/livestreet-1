#!/usr/bin/env php
<?php

/*
    -------------------------------------------------------
*
*   LiveStreet (v.1.x)
*   Plugin Cleaner (v.0.9)
*   Copyright © 2013 Bishovec Nikolay
*
    --------------------------------------------------------
*
*   Plugin Page: http://netlanc.net
*   Contact e-mail: netlanc@yandex.ru
*
    ---------------------------------------------------------
*/

define('SYS_HACKER_CONSOLE', false);
require_once(dirname(dirname(dirname(__FILE__))) . '/config/loader.php');
require_once(Config::Get('path.root.engine') . "/classes/Engine.class.php");
$oEngine = Engine::getInstance();
$oEngine->Init();

$aParams = Config::Get('plugin.cleaner.clean_cron');
if (!empty($aParams)) {
    $oEngine->PluginCleaner_Cleaner_Clean($aParams);
}

?>
