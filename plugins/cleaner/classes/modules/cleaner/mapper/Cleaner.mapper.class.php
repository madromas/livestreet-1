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

class PluginCleaner_ModuleCleaner_MapperCleaner extends Mapper
{
    /**
     * Работа с блогами
     */

    /**
     * Очистка голосования
     *
     * @param $sTargetType
     * @param $aTargetId
     * @return bool
     */
    public function CleanVote($sTargetType, $aTargetId)
    {
        if (!is_array($aTargetId) or empty($aTargetId)) {
            return false;
        }
        $sql = "DELETE FROM " . Config::Get('db.table.vote') . " WHERE target_type = ? AND target_id IN (?a)";
        if ($this->oDb->select($sql, $sTargetType, $aTargetId)) {
            return true;
        }
        return false;
    }

    /**
     * Очистка избранного
     *
     * @param $sTargetType
     * @param $aTargetId
     * @return bool
     */
    public function CleanFavourite($sTargetType, $aTargetId)
    {
        if (!is_array($aTargetId) or empty($aTargetId)) {
            return false;
        }
        $sql = "DELETE FROM " . Config::Get('db.table.favourite') . " WHERE target_type = ? AND target_id IN (?a)";
        if ($this->oDb->select($sql, $sTargetType, $aTargetId)) {
            return true;
        }
        return false;
    }

    /**
     * Изменяем у комментариев id блогов0
     *
     * @param $aArray
     * @return bool
     */
    public function UpdateCommentsByArrayTargetParentId($iBlogId, $aArray)
    {
        if (!is_array($aArray) or empty($aArray)) {
            return false;
        }

        $sql = "UPDATE " . Config::Get('db.table.comment') . " SET target_parent_id = ? WHERE target_parent_id IN (?a)";
        if ($this->oDb->query($sql, $iBlogId, $aArray)) {
            $sql = "UPDATE " . Config::Get('db.table.comment_online') . " SET target_parent_id = ? WHERE target_parent_id IN (?a)";
            $this->oDb->query($sql, $iBlogId, $aArray);
            return true;
        }
        return false;
    }

    /**
     * Изменяем владельца у блогов
     *
     * @param $aArray
     * @return bool
     */
    public function UpdateBlogByArrayBlogId($iUserId, $aArray)
    {
        if (!is_array($aArray) or empty($aArray)) {
            return false;
        }

        $sql = "UPDATE " . Config::Get('db.table.blog') . " SET user_owner_id = ? WHERE blog_id IN (?a)";
        if ($this->oDb->query($sql, $iUserId, $aArray)) {
            return true;
        }
        return false;
    }

    /**
     * Изменяем у топиков id блога
     *
     * @param $aArray
     * @return bool
     */
    public function UpdateTopicsByArrayBlogId($iBlogId, $aArray)
    {
        if (!is_array($aArray) or empty($aArray)) {
            return false;
        }

        $sql = "UPDATE " . Config::Get('db.table.topic') . " SET blog_id = ? WHERE blog_id IN (?a)";
        if ($this->oDb->query($sql, $iBlogId, $aArray)) {
            return true;
        }
        return false;
    }

    /**
     * Удаляем комментарии топиков удаляемых блогов
     *
     * @param $aArray
     * @return bool
     */
    public function DeleteCommentsByArrayTargetParentId($aArray)
    {
        if (!is_array($aArray) or empty($aArray)) {
            return false;
        }

        $sql = "DELETE FROM " . Config::Get('db.table.comment') . " WHERE target_parent_id IN (?a)";
        if ($this->oDb->select($sql, $aArray)) {
            $sql = "DELETE FROM " . Config::Get('db.table.comment_online') . " WHERE target_parent_id IN (?a)";
            $this->oDb->select($sql, $aArray);
            return true;
        }
        return false;
    }

    /**
     * Удаляем топики удаляемых блогов
     *
     * @param $aArray
     * @return bool
     */
    public function DeleteTopicsByArrayBlogId($aArray)
    {
        if (!is_array($aArray) or empty($aArray)) {
            return false;
        }

        $sql = "DELETE FROM " . Config::Get('db.table.topic') . " WHERE blog_id IN (?a)";
        if ($this->oDb->select($sql, $aArray)) {
            return true;
        }
        return false;
    }

    /**
     * Удаляем топики удаляемых блогов
     *
     * @param $aArray
     * @return bool
     */
    public function DeleteBlogByArrayBlogId($aArray)
    {
        if (!is_array($aArray) or empty($aArray)) {
            return false;
        }

        $sql = "DELETE FROM " . Config::Get('db.table.blog') . " WHERE blog_id IN (?a)";
        if ($this->oDb->select($sql, $aArray)) {
            return true;
        }
        return false;
    }

    /**
     * Собираем коменты котрые подлежат изменению/удалению
     *
     * @param $aArray
     * @return array|bool
     */
    public function GetCommentByArrayTargetParentId($aArray)
    {
        if (!is_array($aArray) or empty($aArray)) {
            return false;
        }

        $sql = "SELECT comment_id FROM " . Config::Get('db.table.comment') . " WHERE target_parent_id IN (?a)";
        $aTopicId = array();
        if ($aRows = $this->oDb->select($sql, $aArray)) {
            foreach ($aRows as $aRow) {
                $aTopicId[] = $aRow['comment_id'];
            }
            return $aTopicId;
        }
        return false;
    }

    /**
     * Собираем топики котрые подлежат изменению/удалению
     *
     * @param $aArray
     * @return array|bool
     */
    public function GetTopicByArrayBlogId($aArray)
    {
        if (!is_array($aArray) or empty($aArray)) {
            return false;
        }

        $sql = "SELECT topic_id FROM " . Config::Get('db.table.topic') . " WHERE blog_id IN (?a)";
        $aTopicId = array();
        if ($aRows = $this->oDb->select($sql, $aArray)) {
            foreach ($aRows as $aRow) {
                $aTopicId[] = $aRow['topic_id'];
            }
            return $aTopicId;
        }
        return false;
    }

    /**
     * Пересчет пользователей вступивших в блог
     *
     * @return bool
     */
    public function RecalculateBlogUser()
    {
        $sql = "SELECT bu.user_id FROM " . Config::Get('db.table.blog_user') . " as bu";

        if ($aRows = $this->oDb->query($sql)) {
            foreach ($aRows as $aRow) {
                $iUserId = $aRow['user_id'];
                $sql = "SELECT user_id FROM " . Config::Get('db.table.user') . " WHERE user_id = ?d";
                if (!$aRow = $this->oDb->selectRow($sql, $iUserId)) {
                    $sql = "DELETE FROM " . Config::Get('db.table.blog_user') . " WHERE user_id = ?d";
                    $this->oDb->query($sql, $iUserId);
                }
            }
        }

        return true;
    }

    /**
     * Поиск пользователей потерявших персональный блог
     *
     * @return array
     */
    public function GetUsersNotPersonalBlog()
    {
        $sql = "SELECT user_id, user_login FROM " . Config::Get('db.table.user');

        $aResult = array();
        if ($aRows = $this->oDb->query($sql)) {
            foreach ($aRows as $aUser) {
                $sql = "SELECT blog_id FROM " . Config::Get('db.table.blog') . " WHERE blog_type = ? AND user_owner_id = ?d";
                if (!$aRow = $this->oDb->selectRow($sql, 'personal', $aUser['user_id'])) {
                    $aResult[] = Engine::GetEntity('User', $aUser);
                }
            }
        }
        return $aResult;
    }

    /**
     * Собирает блоги без владельца
     *
     * @param $aFilter
     * @return array
     */
    public function GetCollectiveBlogsNotOwner($aFilter)
    {
        $sWhere = '';
        if (!empty($aFilter['type_in'])) {
            if (!is_array($aFilter['type_in'])) {
                $aFilter['type_in'] = array($aFilter['type_in']);
            }
            $sWhere .= " AND b.blog_type IN ('" . join("','", $aFilter['type_in']) . "')";
        }
        if (!empty($aFilter['type_not_in'])) {
            if (!is_array($aFilter['type_not_in'])) {
                $aFilter['type_not_in'] = array($aFilter['type_not_in']);
            }
            $sWhere .= " AND b.blog_type NOT IN ('" . join("','", $aFilter['type_not_in']) . "')";
        }

        $sql = "SELECT b.blog_id, b.user_owner_id FROM " . Config::Get('db.table.blog') . " as b WHERE 1=1 $sWhere";

        $aBlogId = array();
        if ($aRows = $this->oDb->query($sql)) {
            foreach ($aRows as $aBlog) {
                $sql = "SELECT user_id FROM " . Config::Get('db.table.user') . " WHERE user_id = ?d";
                if (!$aRow = $this->oDb->selectRow($sql, $aBlog['user_owner_id'])) {
                    $aBlogId[] = $aBlog['blog_id'];
                }
            }
        }
        return $aBlogId;
    }

    /**
     * Работа с комментариями
     */

    /**
     * Пересчет счетчиков комментариев в топиках
     *
     * @return bool
     */
    public function RecalcCommentTopic()
    {
        $sql = "
                UPDATE " . Config::Get('db.table.topic') . " t
                    SET t.topic_count_comment = (
                        SELECT count(c.comment_id)
                        FROM " . Config::Get('db.table.comment') . " c
                        WHERE
                            c.target_id = t.topic_id
                        AND
                            c.comment_publish = 1
                        AND
                            c.target_type = 'topic'
                    )
                ";
        if ($this->oDb->query($sql)) {
            return true;
        }
        return false;
    }

    /**
     * Пересчет счетчиков коментариев в личке
     *
     * @return bool
     */
    public function RecalcCommentTalk()
    {
        $sql = "
                UPDATE " . Config::Get('db.table.talk') . " t
                    SET t.talk_count_comment = (
                        SELECT count(c.comment_id)
                        FROM " . Config::Get('db.table.comment') . " c
                        WHERE
                            c.target_id = t.talk_id
                        AND
                            c.comment_publish = 1
                        AND
                            c.target_type = 'talk'
                    )
                ";
        if ($this->oDb->query($sql)) {
            return true;
        }
        return false;
    }

    /**
     * Финальное удаление коментариев по полю comment_delete
     *
     * @return bool
     */
    public function DeleteComment()
    {
        $sql = "DELETE FROM " . Config::Get('db.table.comment') . " WHERE comment_delete = 1";
        if ($this->oDb->select($sql)) {
            return true;
        }
        return false;
    }

    /**
     * Финальное удаление коментариев по полю comment_delete
     *
     * @return bool
     */
    public function DeleteCommentArray($aArray)
    {
        if (!is_array($aArray) or empty($aArray)) {
            return false;
        }

        $sql = "DELETE FROM " . Config::Get('db.table.comment') . " WHERE comment_id IN (?a)";
        if ($this->oDb->select($sql, $aArray)) {
            $sql = "DELETE FROM " . Config::Get('db.table.comment_online') . " WHERE comment_id IN (?a)";
            $this->oDb->select($sql, $aArray);
            return true;
        }
        return false;
    }

    /**
     * Сбор удаленных коментариев
     *
     * @return array|bool|null
     */
    public function GetCommentsDeleted()
    {
        $sql = "SELECT comment_id, comment_pid, target_id, target_type FROM " . Config::Get('db.table.comment') . " WHERE comment_delete = 1";
        if ($aRows = $this->oDb->select($sql)) {
            return $aRows;
        }
        return false;
    }

    /**
     * Сбор коментариев по родителю
     *
     * @param $iCommentId
     * @return array|bool
     */
    public function GetCommentsByPid($iCommentId)
    {
        $sql = "SELECT comment_id, comment_delete FROM " . Config::Get('db.table.comment') . " WHERE comment_pid = ?";
        $aChildren = array();
        if ($aRows = $this->oDb->select($sql, $iCommentId)) {
            foreach ($aRows as $aRow) {
                $aChildren[$aRow['comment_id']] = $aRow['comment_delete'];
            }
            return $aChildren;
        }
        return false;
    }

    /**
     * Получение коментариев по родителю
     *
     * @param $iCommentId
     * @return array|bool
     */
    public function GetCommentsChildrenByCommentId($iCommentId)
    {
        $sql = "SELECT comment_id FROM " . Config::Get('db.table.comment') . " WHERE comment_pid = ?";
        $aChildren = array();
        if ($aRows = $this->oDb->select($sql, $iCommentId)) {
            foreach ($aRows as $aRow) {
                $aChildren[] = $aRow['comment_id'];
            }
            return $aChildren;
        }
        return false;
    }

    /**
     * Установка pid дочерних комментариев в null
     *
     * @param $aCommentId
     * @return bool
     */
    public function UpdateCommentTargetNullArray($aCommentId)
    {
        if (!is_array($aCommentId) or empty($aCommentId)) {
            return false;
        }

        $sql = "UPDATE " . Config::Get('db.table.comment') . " SET comment_pid = ? WHERE comment_pid IN (?a)";
        if ($this->oDb->query($sql, null, $aCommentId)) {
            return true;
        }
        return false;
    }

    /**
     * Изменение pid дочерних комментариев массивом
     *
     * @param $aCommentPid
     * @return bool
     */
    public function UpdateCommentPidArray($aCommentPid)
    {
        if (!is_array($aCommentPid) or empty($aCommentPid)) {
            return false;
        }

        $sql = "UPDATE " . Config::Get('db.table.comment') . " SET comment_pid = ? WHERE comment_pid = ?";
        foreach ($aCommentPid as $iIdOld => $iIdNew) {
            $this->oDb->query($sql, $iIdNew, $iIdOld);
        }
    }

    /**
     * Получение данных по id комментария
     *
     * @param $iCommentId
     * @return array|bool|mixed|null
     */
    public function GetCommentById($iCommentId)
    {
        $sql = "SELECT comment_id, comment_pid, comment_delete FROM " . Config::Get('db.table.comment') . " WHERE comment_id = ?";
        if ($aRow = $this->oDb->selectRow($sql, $iCommentId)) {
            return $aRow;
        }
        return false;
    }

    /**
     * Работа с файлами
     */

    /**
     * Поиск файла в таблицах
     *
     * @param $sFile
     * @return bool
     */
    public function SearchFile($sFile)
    {
        $aTableClean = Config::Get('plugin.cleaner.table_images');

        if (!empty($aTableClean)) {
            foreach ($aTableClean as $aTable) {

                if (!empty($aTable['table']) and !empty($aTable['fields'])) {

                    $sTable = $aTable['table'];
                    $sWhere = '(' . implode(" LIKE '%{$sFile}%' ) OR ( ", $aTable['fields']) . " LIKE '%{$sFile}%')";

                    $sql = "SELECT count(*) as count FROM " . Config::Get('db.table.prefix') . $sTable . " WHERE " . $sWhere;

                    if ($aRow = $this->oDb->selectRow($sql)) {
                        if ($aRow['count'] > 0) {
                            return true;
                        }
                    }
                }
            }
        }

        return false;
    }

}

?>
