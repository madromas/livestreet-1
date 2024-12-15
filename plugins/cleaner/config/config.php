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

$config = array();

$config['folder_not_search'] = array(       // список папок в uploads по котрым не искать изображения: .. и . НЕ УДАЛЯТЬ!
    '.',
    '..'
);

$config['children_comments'] = 'pid';       // что делать с дочерними коментариями удаленного коментария:
                                            // delete - удалить;
                                            // target - сделать первый коментарий в ветке родителем новой ветки;
                                            // pid - перенести первый коментарий в ветке родителю удаленного коментария;

$config['blog'] = array(
    'collective_action' => 'delete',          // что делать с колективными блогами у которых не найден владелец
                                            // delete - удалять
                                            // edit - изменить владельца
    'collective_owner_id' => 1,             // id пользователя которому переносить найденые коллективные блоги с отсутствующими владельцами, только с 'collective_action' = 'edit'
    'collective_topic' => 'edit',           // что делать с топиками удаляемого коллективного блога, только с  'collective_action' = 'delete'
                                            // delete - удалить
                                            // edit - изменить родительский блог
    'collective_topic_new_blog_id' => 1,    // id нового блога который будет присвоен топикам, только с  'collective_topic' = 'delete
);

/**
 * Список таблиц и полей по которым искать изображения
 */
$config['table_images'] = array(
    array(
        'table' => 'topic_content',         // имя таблицы в которой будет осуществляться поиск
        'fields' => array(                  // список полей по которым будет осуществояться поиск
            'topic_text_source',
        )
    ),
    array(
        'table' => 'topic_photo',
        'fields' => array(
            'path',
        )
    ),
    array(
        'table' => 'comment',
        'fields' => array(
            'comment_text',
        )
    ),
    array(
        'table' => 'blog',
        'fields' => array(
            'blog_description',
        )
    ),
    array(
        'table' => 'talk',
        'fields' => array(
            'talk_text',
        )
    ),
    array(
        'table' => 'user',
        'fields' => array(
            'user_profile_foto', 'user_profile_avatar', 'user_profile_about'
        )
    ),
    array(
        'table' => 'wall',
        'fields' => array(
            'text',
        )
    ),
    /**
     * раскоментировать код ниже для включение в поиск по таблицам статических страниц
     */
    /*array(
        'table' => 'page',
        'fields' => array(
            'page_text',
        )
    ),*/
);

/**
 * Что использовать при очистке по крону, раскоментируйте те строчки которые хотите использовать
 */

$config['clean_cron'] = array(
    //'comments',     // очистить удаленные коментарии
    //'counters',     // пересчитать счетчики
    //'images',     // очистить изображения
    //'relations'   // очистить левые связи
);

return $config;
?>
