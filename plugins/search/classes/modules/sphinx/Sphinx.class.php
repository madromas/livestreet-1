<?php

/* -------------------------------------------------------
 *
 *   LiveStreet (v.1.x)
 *   Plugin Search (v.0.1)
 *   Copyright © 2013 Bishovec Nikolay
 *
   --------------------------------------------------------
 *
 *   Plugin Page: http://netlanc.net
 *   Contact e-mail: netlanc@yandex.ru
 *
   ---------------------------------------------------------
 */

class PluginSearch_ModuleSphinx extends PluginSearch_Inherit_ModuleSphinx
{
    protected $oMapper;

    /**
     * Инизиализация модуля
     */
    public function Init()
    {
        parent::Init();
        $this->oMapper = Engine::GetMapper(__CLASS__);
    }

    public function FindContent($sTerms, $sObjType, $iOffset, $iLimit, $aExtraFilters)
    {
        //print_r(array(Config::Get('module.search.entity_prefix') . $sObjType . 'Index', $sTerms, $sObjType, $iOffset, $iLimit, $aExtraFilters));
        //return;
        /**
         * используем кеширование при поиске
         */
        $sExtraFilters = serialize($aExtraFilters);
        $cacheKey = Config::Get('module.search.entity_prefix') . "searchResult_{$sObjType}_{$sTerms}_{$iOffset}_{$iLimit}_{$sExtraFilters}";
        if (false === ($data = $this->Cache_Get($cacheKey))) {

            /**
             * Клеим метод для нужного запроса
             */
            $sMethod = Config::Get('module.search.entity_prefix') . $sObjType . 'Index';
            /**
             * Ищем
             */
            if (!is_array($data = $this->$sMethod($sTerms, $iOffset, $iLimit))) {
                return FALSE; // Скорее всего недоступен демон searchd
            }
            /**
             * Если результатов нет, то и в кеш писать не стоит...
             * хотя тут момент спорный
             */
            if ($data['total'] > 0) {
                $this->Cache_Set($data, $cacheKey, array(), 60 * 15);
            }
        }
        return $data;
    }

    public function topicsIndex($sTerms, $iPage = 1, $iLimit = 10)
    {
        $iPage = $iPage == 0 ? 1 : $iPage;

        $aRes = array('result' => array(), 'matches' => array(), 'total' => 0, 'total_found' => 0);

        $aResId = $this->oMapper->searchTopic($sTerms, $iCount, $iPage, $iLimit);

        if (!empty($aResId)) {
            $aRes['result'] = $aResId;
            $aRes['matches'] = $aResId;
            $aRes['total'] = $iCount;
            $aRes['total_found'] = $iCount;
        }
        return $aRes;
    }

    public function commentsIndex($sTerms, $iPage, $iLimit)
    {
        $iPage = $iPage == 0 ? 1 : $iPage;

        $aRes = array('result' => array(), 'matches' => array(), 'total' => 0, 'total_found' => 0);

        $aResId = $this->oMapper->searchСomment($sTerms, $iCount, $iPage, $iLimit);

        if (!empty($aResId)) {
            $aRes['result'] = $aResId;
            $aRes['matches'] = $aResId;
            $aRes['total'] = $iCount;
            $aRes['total_found'] = $iCount;
        }
        return $aRes;
    }

    public function GetSnippet($sText, $sIndex, $sTerms, $before_match, $after_match)
    {
        $newTerms = str_replace('[[:<:]]', '<span class="searched-item">', $sTerms);
        $newTerms = str_replace('[[:>:]]', '<span class="searched-item">', $newTerms);
        $sRegExp = '/' . $newTerms . '/iumUS';

        $sText = preg_replace($sRegExp, '<span class="searched-item">$0</span>', strip_tags($sText));
        return $sText;
    }

}

?>
