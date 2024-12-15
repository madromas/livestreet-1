<?php
/**
 * Хук для плагина Similar
 */
class PluginSimilar_HookSimilar extends Hook {

        /**
         * Регистрируем хук на topic_show
         *
         * @return void
         */
        public function RegisterHook() {
                $this->AddHook("topic_show", "topicShowed", __CLASS__);
        }

        /**
         * Получаем список похожих топиков, передаем их в Viewer и добавляем нужный блок в сайдбар
         *
         * @param array $aVars
         */
        function topicShowed($aVars) {
                if(isset($aVars['oTopic'])) {
                        $this->Viewer_AddBlock(
                                'left',
                                'similarTopics',
                                array('plugin' => 'similar', 'oTopic' => $aVars['oTopic']),
                                Config::Get('plugin.similar.topics_block_priority')
                        );
                }
        }
}


