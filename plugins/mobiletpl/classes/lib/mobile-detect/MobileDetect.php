<?php

class MobileDetect {

    static protected $bIsNeedShowMobile=null;
    /**
     * Выполняет запрос к API сервиса
     *
     * @param array $aRequest   Список параметров
     *
     * @return bool|array
     */

    /**
     * Определение типа устройства - мобильное или нет
     *
     * @return bool
     */
    static public function DetectMobileDevice() {
        $detect = new Mobile_Detect;
        if ( $detect->isMobile() ) {
            return true;
        }
        
        return false;
    }

    static public function IsNeedShowMobile() {
        if (!is_null(self::$bIsNeedShowMobile)) {
            return self::$bIsNeedShowMobile;
        }
        /**
         * Принудительно включаем мобильную версию
         */
        if (getRequest('force-mobile',false,'get')=='on') {
            setcookie('use_mobile',1,time()+60*60*24*30,Config::Get('sys.cookie.path'),Config::Get('sys.cookie.host'),false);
            return self::$bIsNeedShowMobile=true;
        }
        /**
         * Принудительно включаем полную версию
         */
        if (getRequest('force-mobile',false,'get')=='off') {
            setcookie('use_mobile',0,time()+60*60*24*30,Config::Get('sys.cookie.path'),Config::Get('sys.cookie.host'),false);
            return self::$bIsNeedShowMobile=false;
        }
        /**
         * Пользователь уже использует мобильную или полную версию
         */
        if (isset($_COOKIE['use_mobile'])) {
            if ($_COOKIE['use_mobile']) {
                return self::$bIsNeedShowMobile=true;
            } else {
                return self::$bIsNeedShowMobile=false;
            }
        }
        /**
         * Запускаем авто-определение мобильного клиента
         */
        if (self::DetectMobileDevice()) {
            setcookie('use_mobile',1,time()+60*60*24*30,Config::Get('sys.cookie.path'),Config::Get('sys.cookie.host'),false);
            return self::$bIsNeedShowMobile=true;
        } else {
            setcookie('use_mobile',0,time()+60*60*24*30,Config::Get('sys.cookie.path'),Config::Get('sys.cookie.host'),false);
            return self::$bIsNeedShowMobile=false;
        }
    }

    static public function IsMobileTemplate($bHard=true) {
        if ($bHard) {
            return self::IsNeedShowMobile();
        } else {
            return Config::Get('plugin.mobiletpl.template') && Config::Get('view.skin')==Config::Get('plugin.mobiletpl.template');
        }
    }
}