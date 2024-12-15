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

class PluginChat_HookChat extends Hook
{
    public function RegisterHook()
    {
        $this->AddHook('template_body_end', 'BodyBegin');
    }

    public function BodyBegin()
    {
        return $this->Viewer_Fetch(Plugin::GetTemplatePath('chat') . 'body_begin.tpl');
    }
}

?>