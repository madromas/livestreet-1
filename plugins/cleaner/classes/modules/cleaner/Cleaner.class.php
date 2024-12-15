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

class PluginCleaner_ModuleCleaner extends Module
{

    protected $oMapper;
    protected $aCommentDelete = array();
    protected $aCommentPid = array();

    public function Init()
    {

        $this->oMapper = Engine::GetMapper(__CLASS__);
    }

    /**
     * Запуск пылесоса
     *
     * @param array $aParams
     * @return bool
     */
    public function Clean($aParams = array())
    {
        if (!empty($aParams)) {
            foreach ($aParams as $sParam) {
                $sMethod = 'Clean' . ucfirst($sParam);
                if (method_exists($this, $sMethod)) {
                    $this->$sMethod();
                }
            }
            $this->Cache_Clean();
            return true;
        }
        return false;
    }

    /**
     * Пересчет счетчиков комментариев в топиках и личке
     */
    public function CleanCounters()
    {
        /**
         * Запуск пересчета кометариев к топикам
         */
        $this->RecalcCommentsTopic();
        /**
         * Запуск пересчета кометариев к личным сообщениям
         */
        $this->RecalcCommentsTalk();
    }

    /**
     * Запуск очистки потеряных связей
     */
    public function CleanRelations()
    {
        /**
         * Подчищаем коллективные блоги с потеряными владельцами
         */
        $this->CleanRelationCollectiveBlogOwner();
        /**
         * Подчищаем персональные блоги с потеряными владельцами
         */
        $this->CleanRelationPersonalBlogOwner();
        /**
         * Востанавливаем потеряные персональные блоги
         */
        $this->RestoreRelationPersonalBlog();
        /**
         * Удаляем потеряные связи пользователей присоединенных в коллективные блоги блогов
         */
        $this->RecalculateBlogUser();
    }

    /**
     * Пересчет пользователей вступивших в блог
     */
    public function RecalculateBlogUser()
    {
        $this->oMapper->RecalculateBlogUser();
    }

    /**
     * Создание потеряных личных блогов
     */
    public function RestoreRelationPersonalBlog()
    {
        if ($aUser = $this->oMapper->GetUsersNotPersonalBlog()) {
            foreach ($aUser as $oUser) {
                $this->Blog_CreatePersonalBlog($oUser);
            }
        }
    }

    /**
     * Формирование операций по работе с потеряными персональными блогами
     *
     * @return mixed
     */
    public function CleanRelationPersonalBlogOwner()
    {
        if ($aBlogId = $this->oMapper->GetCollectiveBlogsNotOwner(array('type_in' => 'personal'))) {
            return $this->CleanRelationCollectiveBlogOwnerDelete($aBlogId);
        }
    }

    /**
     * Формирование операций по работе с потеряными колективными блогами
     *
     * @return mixed
     */
    public function CleanRelationCollectiveBlogOwner()
    {
        if ($aBlogId = $this->oMapper->GetCollectiveBlogsNotOwner(array('type_not_in' => 'personal'))) {
            $sMethod = 'CleanRelationCollectiveBlogOwner' . ucfirst(Config::Get('plugin.cleaner.blog.collective_action'));
            if (method_exists($this, $sMethod)) {
                return $this->$sMethod($aBlogId);
            }
        }
    }

    /**
     * Изменение владельца блога
     *
     * @param $aBlogId
     */
    public function CleanRelationCollectiveBlogOwnerEdit($aBlogId)
    {
        $iUserOwnerIdNew = Config::Get('plugin.cleaner.blog.collective_owner_id');
        $this->oMapper->UpdateBlogByArrayBlogId($iUserOwnerIdNew, $aBlogId);
    }

    /**
     * Удаляем блоги по массиву ID
     *
     * @param $aBlogId
     */
    public function CleanRelationCollectiveBlogOwnerDelete($aBlogId)
    {
        $sMethod = 'CleanRelationBlogTopic' . ucfirst(Config::Get('plugin.cleaner.blog.collective_topic'));
        if (method_exists($this, $sMethod)) {
            $this->$sMethod($aBlogId);
        }
        $this->oMapper->DeleteBlogByArrayBlogId($aBlogId);

        $this->CleanVote('blog', $aBlogId);
        $this->CleanFavourite('blog', $aBlogId);
    }

    public function CleanRelationBlogTopicEdit($aBlogId)
    {
        /**
         * Собираем ID удаляемых топиков для изменени их комментариев
         */
        //$aTopicId = $this->oMapper->GetTopicByArrayBlogId($aBlogId);
        //$aCommentId = $this->oMapper->GetCommentByArrayTargetParentId($aBlogId);
        $iBlodIdNew = Config::Get('plugin.cleaner.blog.collective_topic_new_blog_id');
        /**
         * Изменяем id блога у топиков по ид блогов
         */
        $this->oMapper->UpdateTopicsByArrayBlogId($iBlodIdNew, $aBlogId);
        /**
         * Изменяем id блога у комментариев
         */
        $this->oMapper->UpdateCommentsByArrayTargetParentId($iBlodIdNew, $aBlogId);
    }

    /**
     * Удаляет топики удаляемого блога и комментарии
     *
     * @param $aBlogId
     */
    public function CleanRelationBlogTopicDelete($aBlogId)
    {
        /**
         * Собираем ID удаляемых топиков для удаления их комментариев
         */
        $aTopicId = $this->oMapper->GetTopicByArrayBlogId($aBlogId);
        $aCommentId = $this->oMapper->GetCommentByArrayTargetParentId($aBlogId);
        /**
         * Удаляем топики удаляемых блогов
         */
        $this->oMapper->DeleteTopicsByArrayBlogId($aBlogId);
        /**
         * Удаляем комментарии топиков удаляемых блогов
         */
        $this->oMapper->DeleteCommentsByArrayTargetParentId($aBlogId);
        /**
         * Чистим vote
         */
        $this->CleanVote('topic', $aTopicId);
        $this->CleanVote('comment', $aCommentId);
        /**
         * Чистим favourite
         */
        $this->CleanFavourite('topic', $aTopicId);
        $this->CleanFavourite('comment', $aCommentId);
    }

    /**
     * Удаление данных о голосах
     *
     * @param $sTargetType
     * @param $aTargetId
     */
    public function CleanVote($sTargetType, $aTargetId)
    {
        $this->oMapper->CleanVote($sTargetType, $aTargetId);
    }

    /**
     * Удаление данных о избранном
     *
     * @param $sTargetType
     * @param $aTargetId
     */
    public function CleanFavourite($sTargetType, $aTargetId)
    {
        $this->oMapper->CleanFavourite($sTargetType, $aTargetId);
    }

    /**
     * Проверка наличия файлов в БД и удаление
     */
    public function CleanImages()
    {
        if ($aFiles = $this->GetFiles(array(), Config::Get('path.root.server') . '/uploads')) {
            foreach ($aFiles as $aFile) {

                $sFile = $aFile['name'];
                $aSizes = Config::Get('module.topic.photoset.size');

                foreach ($aSizes as $aSize) {
                    $sSize = $aSize['w'];
                    if ($aSize['crop']) {
                        $sSize .= 'crop';
                    }
                    $sFile = str_replace('_' . $sSize, '', $sFile);
                }

                if (!$this->oMapper->SearchFile($sFile)) {
                    @unlink($aFile['dirname']);
                }

            }
        }
        return;
    }

    /**
     * Сбор файлов
     *
     * @param array $aFiles
     * @param string $sDirName
     * @return array
     */
    public function GetFiles($aFiles = array(), $sDirName = '')
    {
        if ($rRirHandle = opendir($sDirName)) {
            while (($sFile = readdir($rRirHandle)) !== false) {
                if (!in_array($sFile, Config::Get('plugin.cleaner.folder_not_search'))) {
                    if (is_dir($sDirName . "/" . $sFile)) {
                        $aFiles = $this->GetFiles($aFiles, $sDirName . "/" . $sFile);
                    } else {
                        $aTmpFile['name'] = $sFile;
                        $aTmpFile['dirname'] = $sDirName . "/" . $sFile;
                        $aFiles[] = $aTmpFile;
                    }
                }
            }
        }
        return $aFiles;
    }

    /**
     * Очистка коментариев
     */
    public function CleanComments()
    {
        if ($aComments = $this->oMapper->GetCommentsDeleted()) {

            $aTarget = array();
            $aChildren = array();
            foreach ($aComments as $aComment) {
                $aTarget[$aComment['target_type']][$aComment['target_id']][] = $aComment['comment_id'];

                $this->aCommentDelete[] = $aComment['comment_id'];

                if ($aCommentChildren = $this->oMapper->GetCommentsByPid($aComment['comment_id'])) {
                    $aChildren[$aComment['comment_id']] = array('comment_pid' => $aComment['comment_pid'], 'children' => $aCommentChildren);
                }
            }

            if (!empty($aChildren)) {
                $this->BuildingTreeComment($aChildren);
            }

            $this->DeleteComment();
            $this->RecalcTarget($aTarget);
        }
    }

    /**
     * Перестроение дерева комментариев
     * @param $aChildren
     * @return mixed
     */
    public function BuildingTreeComment($aChildren)
    {
        $sMethod = 'BuildingTreeComment' . ucfirst(Config::Get('plugin.cleaner.children_comments'));
        if (method_exists($this, $sMethod)) {
            return $this->$sMethod($aChildren);
        }
    }

    /**
     * Перестроение коментариев по pid
     *
     * @param $aChildren
     */
    public function BuildingTreeCommentPid($aChildren)
    {

        foreach ($aChildren as $iCommentId => $aComment) {
            $iCommentPid = null;
            if ($aComment['comment_pid'] == null) {
                $this->aCommentPid[$iCommentId] = null;
            } else {
                $iCommentPid = $this->GetCommentIdByPidActive($aComment['comment_pid']);
                $this->aCommentPid[$iCommentId] = $iCommentPid;
            }
        }
        $this->SetPidCommentTree();

    }

    /**
     * Получение активного pid
     *
     * @param $iCommentId
     * @return null
     */
    public function GetCommentIdByPidActive($iCommentId)
    {

        if ($aComment = $this->oMapper->GetCommentById($iCommentId)) {
            if ($aComment['comment_delete'] != 1) {
                return $aComment['comment_id'];
            } else {
                if ($aComment['comment_pid'] != null) {
                    return $this->GetCommentIdByPidActive($aComment['comment_pid']);
                }
            }
        }
        return null;
    }

    /**
     * Установка новых pid
     */
    public function SetPidCommentTree()
    {
        if (!empty($this->aCommentPid)) {
            $this->oMapper->UpdateCommentPidArray($this->aCommentPid);
        }
    }

    /**
     * Перестроение дерева коментариев установкой комментариев началом новой ветки
     *
     * @param $aChildren
     */
    public function BuildingTreeCommentTarget($aChildren)
    {
        $aCommentId = array_keys($aChildren);
        $this->SetTargetCommentTree($aCommentId);
    }

    /**
     * Изменение comment_pid массива коментариев к null
     *
     * @param $aCommentId
     */
    public function SetTargetCommentTree($aCommentId)
    {
        $this->oMapper->UpdateCommentTargetNullArray($aCommentId);
    }

    /**
     * Перестроение дерева коментариев удалением
     * @param $aChildren
     * @return bool
     */
    public function BuildingTreeCommentDelete($aChildren)
    {
        foreach ($aChildren as $iCommentId => $aArray) {
            $aCommentId = array();
            foreach ($aArray['children'] as $iId => $sDelete) {
                $aCommentId[] = $iId;
            }
            $this->GetDeleteCommentTree($aCommentId);
        }
        return true;
    }

    /**
     * Удаление дерева коментариев
     * @param $aCommentId
     */
    public function GetDeleteCommentTree($aCommentId)
    {
        foreach ($aCommentId as $iCommentId) {
            $this->aCommentDelete[] = $iCommentId;
        }
    }

    /**
     * Удаление коментариев
     *
     * @param $aTarget
     */
    public function DeleteComment()
    {
        if (!empty($this->aCommentDelete)) {
            $this->oMapper->DeleteCommentArray($this->aCommentDelete);
        }
    }

    /**
     * Пересчет счетчиков у найденых обьектов
     *
     * @param $aTarget
     */
    public function RecalcTarget($aTarget)
    {
        if (!empty($aTarget)) {
            foreach ($aTarget as $key => $aId) {
                $sMethod = 'RecalcComments' . ucfirst($key);
                if (method_exists($this, $sMethod)) {
                    $aId = array_unique($aId);
                    $this->$sMethod($aId);
                }
            }
        }
    }

    /**
     * Пересчет коментов в топиках
     *
     * @param $aId
     */
    public function RecalcCommentsTopic($aTopic = null)
    {
        $this->oMapper->RecalcCommentTopic();
        if (!empty($aTopic)) {
            foreach ($aTopic as $iTopicId => $aCommentId) {
                $iCount = count($aCommentId);
                /**
                 * Добавить пересчет прочитаных
                 */
                //$this->oMapper->RecalcCountCommentReadTopic($iTopicId, $iCount);
            }
        }
    }

    /**
     * Пересчет коменатриев в личке
     * @param $aId
     */
    public function RecalcCommentsTalk($aTalkId = null)
    {
        $this->oMapper->RecalcCommentTalk();
    }

}

?>
