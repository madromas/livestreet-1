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

if (!class_exists('Plugin')) {
    die('Hacking attemp!');
}

class PluginLl extends Plugin
{

    public $aInherits = array(
        'action' => array('ActionUserfeed' => '_ActionUserfeed'),
        'block' => array('BlockUserfeedBlogs' => '_BlockUserfeedBlogs'),
    );
    public $aDelegates = array(
        'template' => array(
            'block.userfeedBlogs.tpl' => '_block.userfeedBlogs.tpl',
        ),
    );

    public function Activate()
    {
        return true;
    }

    public function Init()
    {

    }

}

?>
