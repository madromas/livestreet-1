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

class PluginChat_ModuleChat_MapperChat extends Mapper
{

    public function GetList($iLimit)
    {
        $sql = "SELECT
					chat_id, user_login, chat_text
				FROM
					" . Config::Get('plugin.chat.table.chat') . "
                WHERE
                    chat_delete = 0
                ORDER BY chat_date_add desc
				LIMIT ?d";
        $aResult = array();
        if ($aRows = $this->oDb->select($sql, $iLimit)) {
            foreach ($aRows as $aRow) {
                $aResult[$aRow['chat_id']] = $aRow;
            }
            $aResult = array_reverse($aResult);
        }
        return $aResult;
    }

    public function Add($aData)
    {
        $sql = "INSERT INTO " . Config::Get('plugin.chat.table.chat') . "
                    (
                    user_id,
                    user_login,
                    chat_text,
                    chat_date_add
                    )
                    VALUES(?d, ?, ?, ?)
                ";
        if ($iId = $this->oDb->query($sql, $aData['id'], $aData['login'], $aData['text'], date('Y-m-d H:i:s'))) {
            return $iId;
        }
        return false;
    }

    public function DeleteHistory()
    {
        $sql = "SELECT MAX(chat_id) FROM " . Config::Get('plugin.chat.table.chat');
        $iMax = $this->oDb->selectCell($sql);
        $iMin = $iMax-Config::Get('plugin.chat.pop_per_page') - 1;
        $sql = "DELETE FROM " . Config::Get('plugin.chat.table.chat') ." WHERE chat_id < ?d";
        if ($this->oDb->query($sql, $iMin)) {
            return true;
        }
        return false;
    }

}

?>