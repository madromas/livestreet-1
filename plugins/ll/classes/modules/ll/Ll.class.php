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

class PluginLl_ModuleLl extends Module
{

    protected $oMapper;

    public function Init()
    {
        $this->oMapper = Engine::GetMapper(__CLASS__);
    }

    /**
     * Получает список всех блогов в алфавитном порядке
     *
     * @param unknown_type $iLimit
     * @return unknown
     */
    public function GetBlogsAlphSort()
    {
        if (false === ($data = $this->Cache_Get("blog_alph_sort"))) {
            $data = array('collection' => $this->oMapper->GetBlogsAlphSort($iCount), 'count' => $iCount);
            $this->Cache_Set($data, "blog_alph_sort", array("blog_update", "blog_new"), 60 * 60 * 24 * 2);
        }
        $data['collection'] = $this->Blog_GetBlogsAdditionalData($data['collection'], array('owner' => array(), 'relation_user'));
        return $data;
    }

}

?>
