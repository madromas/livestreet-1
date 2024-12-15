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

class PluginLl_ModuleLl_MapperLl extends Mapper
{

    /**
     * Получает список всех блогов в алфавитном порядке
     *
     */
    public function GetBlogsAlphSort(&$iCount)
    {
        $sWhere = '';
        if (!Config::Get('plugin.ll.close')) {
            $sWhere .= " AND b.blog_type != 'close'";
        }

        $sql = "SELECT
                    b.blog_id
                FROM
                    " . Config::Get('db.table.blog') . " as b
                WHERE
                    b.blog_type<>'personal'	" .
                    $sWhere . "
                ORDER by b.blog_title";
        $aReturn = array();
        if ($aRows = $this->oDb->selectPage($iCount, $sql)) {
            foreach ($aRows as $aRow) {
                $aReturn[] = $aRow['blog_id'];
            }
        }
        return $aReturn;
    }

}

?>
