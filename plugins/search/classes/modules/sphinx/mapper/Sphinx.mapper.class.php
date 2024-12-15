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

class PluginSearch_ModuleSphinx_MapperSphinx extends Mapper
{

    public function searchTopic($sTerm, &$iCount, $iCurrPage, $iPerPage)
    {
        $sql = "SELECT
                    DISTINCT t.topic_id,
                    CASE WHEN (LOWER(t.topic_title) REGEXP ?) THEN 1 ELSE 0 END +
                    CASE WHEN (LOWER(tc.topic_text_source) REGEXP ?) THEN 1 ELSE 0 END AS weight
                FROM " . Config::Get('db.table.topic') . " AS t
                    LEFT JOIN " . Config::Get('db.table.topic_content') . " AS tc ON tc.topic_id=t.topic_id
                WHERE
                    (topic_publish=1) AND ((LOWER(t.topic_title) REGEXP ?) OR (LOWER(tc.topic_text_source) REGEXP ?))
                ORDER BY
                    weight DESC, t.topic_id ASC
                LIMIT ?d, ?d";

        $aResult = array();
        if ($aRows = $this->oDb->selectPage($iCount, $sql, $sTerm, $sTerm, $sTerm, $sTerm, ($iCurrPage - 1) * $iPerPage, $iPerPage)) {
            foreach ($aRows as $aRow) {
                $aResult[$aRow['topic_id']] = $aRow['topic_id'];
            }
        }
        return $aResult;
    }

    public function searchСomment($sTerm, &$iCount, $iCurrPage, $iPerPage)
    {
        $sql = "SELECT
                    DISTINCT c.comment_id, CASE WHEN (LOWER(c.comment_text) REGEXP ?) THEN 1 ELSE 0 END weight
                FROM " . Config::Get('db.table.comment') . " AS c
                WHERE
                    (comment_delete=0 AND target_type='topic') AND LOWER(c.comment_text) REGEXP ?
                ORDER BY
                    weight DESC, c.comment_id ASC
                LIMIT ?d, ?d";

        $aResult = array();
        if ($aRows = $this->oDb->selectPage($iCount, $sql, $sTerm, $sTerm, ($iCurrPage - 1) * $iPerPage, $iPerPage)) {
            foreach ($aRows as $aRow) {
                $aResult[$aRow['comment_id']] = $aRow['comment_id'];
            }
        }
        return $aResult;
    }

}

?>