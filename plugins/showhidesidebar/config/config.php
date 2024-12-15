<?php

/* -------------------------------------------------------
 *
 *   LiveStreet (v1.x)
 *   Plugin Show hide sidebar (v.0.2)
 *   Copyright © 2013 Bishovec Nikolay
 *
 * --------------------------------------------------------
 *
 *   Plugin Page: http://netlanc.net
 *   Contact e-mail: netlanc@yandex.ru
 *
 ---------------------------------------------------------
 */

$config = array();

$config['action_off'] = array('admin', 'error'); // экшены на которых не использовать скрытие сайдбара
$config['speed'] = 1000 * 0.8; // скорость анимации движения при открытии/закрытии сайдбара в микросекундах
$config['direction'] = 'right'; // направление сворачивания

return $config;
?>