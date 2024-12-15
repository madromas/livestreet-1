<?php

/* -------------------------------------------------------
 *
 *   LiveStreet (v1.x)
 *   Plugin Disable topics from the blog (v.1.0)
 *   Copyright © 2011 Bishovec Nikolay
 *
 * --------------------------------------------------------
 *
 *   Plugin Page: http://netlanc.net
 *   Contact e-mail: netlanc@yandex.ru
 *
  ---------------------------------------------------------
 */

class PluginDtb_ModuleTopic_MapperTopic extends PluginDtb_Inherit_ModuleTopic_MapperTopic
{

    protected function buildFilter($aFilter)
    {
        $aExBlogId = array();
        if ((Router::GetAction() == 'index' and !Router::GetActionEvent()) and $sExBlogId = Config::Get('plugin.dtb.blog_id')) {
            $aExBlogId = explode(',', $sExBlogId);
            if (!empty($aFilter['blog_type']['close'])) {
                $aFilter['blog_type']['close'] = array_diff($aFilter['blog_type']['close'], $aExBlogId);
            }
        }
        $sWhere = parent::buildFilter($aFilter);
        if (!empty($aExBlogId)) {
            $sWhere .= " AND b.blog_id NOT IN(" . implode(', ', $aExBlogId) . ")";
        }
        return $sWhere;
    }

}

?>
