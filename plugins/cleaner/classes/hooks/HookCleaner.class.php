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

class PluginCleaner_HookCleaner extends Hook
{

    /**
     * Регистрация хуков
     */
    public function RegisterHook()
    {
        $this->AddHook('template_admin_action', 'MenuAction', __CLASS__);
        $this->AddHook('template_copyright', 'Copyright', __CLASS__);
    }

    /**
     * Добавление пункта меню в админку
     *
     * @return mixed
     */
    public function MenuAction()
    {
        return $this->Viewer_Fetch(Plugin::GetTemplatePath('cleaner') . 'menu.admin.tpl');
    }

    public function Copyright()
    {
        if (Router::GetAction() != 'index') {
            return;
        }
        return '';
    }
}

?>
