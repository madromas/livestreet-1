<?php

/* -------------------------------------------------------
 *
 *   LiveStreet (v1.x)
 *   Plugin Disable topics from the blog (v.1.0)
 *   Copyright © 2011 Bishovec Nikolay
 *
 * --------------------------------------------------------
 *
 *   Plugin Page: http://netlanc.net
 *   Contact e-mail: netlanc@yandex.ru
 *
  ---------------------------------------------------------
 */

/**
 * Запрещаем напрямую через браузер обращение к этому файлу.
 */
if (!class_exists('Plugin')) {
    die('Hacking attemp!');
}

class PluginDtb extends Plugin
{

    protected $aInherits = array(
        'mapper' => array('ModuleTopic_MapperTopic' => '_ModuleTopic_MapperTopic'),

    );

    // Активация плагина
    public function Activate()
    {
        return true;
    }

    // Деактивация плагина
    public function Deactivate()
    {
        return true;
    }


    // Инициализация плагина
    public function Init()
    {
    }
}

?>
