<?php
/*-------------------------------------------------------
*
*   BlockTop Plugin
*   Copyright 2011 Uladzimir Kulesh
*   Contact e-mail: v.a.kulesh@ya.ru
*
*--------------------------------------------------------
*/
 
$config = array();

$config['topic_top'] = 36000;  // За какой период выводить топ топиков?
/* 1 - за 24 часа,
 * 7 - за 7 дней,
 * 30 - за 30 дней,
 * 36000 - за все время.
 */
 
$config['topic_count'] = 6;  // Сколько записей показывать в блоке?



// Настройки вывода блока

Config::Set('block.rule_blocktop', array(
	'action' => array(
		'index', 'blog' => array('{topics}','{topic}','{blog}')
	),
    'blocks' => array(
		'right' => array(
			'top' => array('params' => array('plugin' => 'blocktop'), 'priority' => 5),
		)
    ),
    'clear' => false,
));

return $config;
?>