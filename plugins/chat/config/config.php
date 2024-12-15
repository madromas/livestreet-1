<?php
/* -------------------------------------------------------
 *
 *   LiveStreet (1.x)
 *   Plugin Chat (free) (v.0.1)
 *   Copyright В© 2013 Bishovec Nikolay
 *
 * --------------------------------------------------------
 *
 *   Plugin Page: http://netlanc.net
 *   Contact e-mail: netlanc@yandex.ru
 *
 * ---------------------------------------------------------
 */

$config=array();

$config['table']['chat']                = '___db.table.prefix___chat';

$config['themes'] = 'blue'; // цветовая схема чата, доступные варианты: liteblue, blue, red, black, orange, green, litegreen

$config['pop_per_page'] = 20; // колличество сообщений в чате

$config['max_length'] = 200; // максимальная длинна сообщения в чате

$config['history_store'] =  false; // сохранять или нет историю чата

Config::Set('router.page.chat_ajax', 'PluginChat_ActionAjax');
Config::Set('router.page.chat', 'PluginChat_ActionChat');

return $config;
?>