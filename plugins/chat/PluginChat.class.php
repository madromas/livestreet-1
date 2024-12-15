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
/**
 * Запрещаем напрямую через браузер обращение к этому файлу.
 */
if (!class_exists('Plugin')) {
    die('Hacking attempt!');
}

class PluginChat extends Plugin
{
    public function Activate()
    {
        if (!$this->isTableExists('prefix_chat')) {
            $this->ExportSQL(dirname(__FILE__) . '/dump.sql');
        }
        return true;
    }

    public function Init()
    {
        $sThemes = Config::Get('plugin.chat.themes');
        if (!in_array($sThemes, array('liteblue', 'blue', 'red', 'black', 'orange', 'green', 'litegreen'))){
            $sThemes='default';
        }
        $this->Viewer_AppendStyle(Plugin::GetTemplateWebPath('chat') . 'css/' . $sThemes . '.css');
        $this->Viewer_AppendStyle(Plugin::GetTemplateWebPath('chat') . 'css/style.css');
    }
}

?>