<?php

/* -------------------------------------------------------
 *
 *   LiveStreet (v.1.x)
 *   Plugin Search (v.0.1)
 *   Copyright © 2013 Bishovec Nikolay
 *
   --------------------------------------------------------
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
	die('Hacking attempt!');
}

class PluginSearch extends Plugin {

	protected $aInherits = array(
		'module' => array(
			'ModuleSphinx',
		),
        'mapper' => array(
            'ModuleSphinx_MapperSphinx',
        ),
    );

	public function Activate() {
		return true;
	}

	public function Init() {

	}
}
?>