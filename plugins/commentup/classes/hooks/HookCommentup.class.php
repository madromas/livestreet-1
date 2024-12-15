<?php

/* -------------------------------------------------------
 *
 *   LiveStreet (1.x)
 *   Plugin Coment Up (v.1.0.1)
 *   Copyright © 2011 Bishovec Nikolay
 *
 * --------------------------------------------------------
 *
 *   Plugin Page: http://netlanc.net
 *   Contact e-mail: netlanc@yandex.ru
 *
  ---------------------------------------------------------
 */

class PluginCommentup_HookCommentup extends Hook
{

    public function RegisterHook()
    {
        $this->AddHook('template_content_begin', 'BodyBegin', __CLASS__);
    }

    public function BodyBegin()
    {
        if (Router::GetAction() == 'index' and !Router::GetActionEvent()) {
            if ($aComments = $this->Comment_GetCommentsOnline('topic', 1)) {
                $aResult = $this->Topic_GetTopicsGood(1, 1);
                $aTopicGoogs = $aResult['collection'];
                sort($aTopicGoogs);
                sort($aComments);
                if (Router::GetAction() == 'index' and (empty($aTopicGoogs) or $aComments[0]->getTarget()->getId() != $aTopicGoogs[0]->getId())) {
                    $oTopic = $aComments[0]->getTarget();
                    $oTopic->setUser($this->User_GetUserById($oTopic->getUserId()));
                    $aTopics[] = $oTopic;

                    $oSmartyObject = $this->Viewer_GetSmartyObject();
                    $aSmartyTopics = $oSmartyObject->tpl_vars['aTopics']->value;
                    if (!empty($aSmartyTopics[$oTopic->getId()])) {
                        unset($this->Viewer_GetSmartyObject()->tpl_vars['aTopics']->value[$oTopic->getId()]);
                        $this->Viewer_Assign('aTopics', $aSmartyTopics);
                    }

                    $this->Viewer_Assign('aCTopics', $aTopics);
                    $this->Viewer_Assign('iTopicUnset', $oTopic->getId());
                    return $this->Viewer_Fetch(Plugin::GetTemplatePath('commentup') . 'topic_list_inj.tpl');
                }
            }
        }
    }

}

?>
