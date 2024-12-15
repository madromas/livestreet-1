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

class PluginShowhidesidebar_HookShowhidesidebar extends Hook
{

    public function RegisterHook()
    {
        $this->AddHook('template_body_begin', 'BodyBegin', __CLASS__, 201);
        $this->AddHook('template_wrapper_class', 'WrapperClass', __CLASS__, 201);

        $this->AddHook('template_copyright', 'Copyright', __CLASS__);
    }

    public function WrapperClass()
    {
        if (in_array(Router::GetAction(), Config::Get('plugin.showhidesidebar.action_off'))){
            return;
        }
        $sClass = '';
        if (!empty($_COOKIE['shs'])){
            $sClass = 'no-sidebar';
        }
        return $sClass;
    }

    public function BodyBegin()
    {
        if (in_array(Router::GetAction(), Config::Get('plugin.showhidesidebar.action_off'))){
            return;
        }
        return $this->Viewer_Fetch(Plugin::GetTemplatePath('showhidesidebar') . '/body_begin.tpl');
    }

    public function Copyright()
    {
        if (Router::GetAction()=='admin'){
            return;
        }
        return '';
    }

}

?>
