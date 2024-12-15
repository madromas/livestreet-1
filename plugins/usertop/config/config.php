<?php
/*-------------------------------------------------------
*
*   UserTop Plugin
*   Copyright 2011 Uladzimir Kulesh
*   Contact e-mail: v.a.kulesh@ya.ru
*
*--------------------------------------------------------
*/

$config = array();

$config['user_count']='16';	// Количество пользователей в блоке

// Настройки вывода блока

Config::Set('block.rule_user_top', array(
    'action' => array(
		'index', 'blog' => array('{topics}','{topic}','{blog}')
    ),
    'blocks' => array(
		'right' => array(
			'usertop' => array('params'=>array('plugin'=>'usertop'), 'priority'=>10),
		)
    ),
    'clear' => false,
));

return $config;
?>