<?php

/* -------------------------------------------------------
 *
 *   LiveStreet (1.x)
 *   Plugin Live Lenta (v.0.2)
 *   Copyright © 2011 Bishovec Nikolay
 *
 * --------------------------------------------------------
 *
 *   Plugin Page: http://netlanc.net
 *   Contact e-mail: netlanc@yandex.ru
 *
  ---------------------------------------------------------
 */

$config = array();
$config['close'] = true; // выводить в список настроек закрытые блоги в которых пользователь состоит / true - да, false - нет

Config::Set('block.rule_lenta', array(
    'action' => array(
        'index', 'feed'
    ),
    'blocks' => array(
        'right' => array(
            'userfeedBlogs' => array('params' => array('plugin' => 'Ll'), 'priority' => 150),
            // раскоментируйте строчку ниже если хотите добавиить на главную форму подкиски на блоги пользователей
            'userfeedUsers' => array('params' => array('plugin' => 'Ll'), 'priority' => 120),
            'stream', 'tags', 'blogs'
        )
    ),
    'clear' => true,
));

return $config;
?>
