<?php

class PluginExtentedimage_ModuleImage extends PluginExtendimage_Inherit_ModuleImage{
	protected $bResize = 0;
	
	public function BuildHTML($sPath,$aParams){
		
		$bNeedResize = $this->Image_isNeedResize($sFileTmp);
		if($bNeedResize){
			$sPreviewPath = $this->Image_GetPreviewServerPath($sPath);
		} else{
			$sPreviewPath = $sPath;
		}
		
		$sText = '';
		if($this->isNeedPopup()){
			$sText .='<br><a href="'.$sPath.'" target="_blank"';
			$sText .=' data-fancybox="'.$sPath.'"';
			//$sText .=' class="clickable_img"';
			$sText .=' >';			
		}

		
		$sText .='<img src="'.$sPreviewPath.'" ';
		if (isset($aParams['title']) and $aParams['title']!='') {
			$sText.=' title="'.htmlspecialchars($aParams['title']).'" ';
			/**
			 * Если не определен ALT заполняем его тайтлом
			 */
			if(!isset($aParams['alt'])) $aParams['alt']=$aParams['title'];
		}
		if (isset($aParams['align']) and in_array($aParams['align'],array('left','right','center'))) {
			if ($aParams['align'] == 'center') {
				$sText.=' class="image-center"';
			} else {
				$sText.=' align="'.htmlspecialchars($aParams['align']).'" ';
			}
		}
		
		
			
			
		if(isset($_REQUEST['form-image-width-upload']) && is_numeric($_REQUEST['form-image-width-upload'])){
			$iWidth = (int)$_REQUEST['form-image-width-upload'];	
		}	

		if(isset($_REQUEST['form-image-width']) && is_numeric($_REQUEST['form-image-width']) && !$iWidth){
			$iWidth = (int)$_REQUEST['form-image-width'];	
		}
				
		if($iWidth > 0){
			$sText .= ' width="'.$iWidth.'"';
		}			
		
		$sText.=$sAlt.' />';

		if($this->isNeedPopup()){
			$sText .='</a>';	
		}		
		
		return $sText;
	}

	public function GetPreviewServerPath($sServerPath){
		$sFileName = basename($sServerPath);
		$sDir = dirname($sServerPath);
		
		$sPreviewFileName = $sDir.'/prev_'.$sFileName;
		
		return $sPreviewFileName;
	}
	
	public function getPreviewConfigKey(){
		if(isset($_REQUEST['sToLoad'])){
			if($_REQUEST['sToLoad'] == 'topic_text'){
				$sEnableKey = 'plugin.extentedimage.topic_preview_enable';
				$sWidthKey = 'plugin.extentedimage.topic_preview_width';			
			} else {
				$sEnableKey = 'plugin.extentedimage.comment_preview_enable';
				$sWidthKey = 'plugin.extentedimage.comment_preview_width';				
			}
		} else {
			$sEnableKey = 'plugin.extentedimage.topic_preview_enable';
			$sWidthKey = 'plugin.extentedimage.topic_preview_width';
		}
		
		return array($sEnableKey,$sWidthKey);
	}
	
	public function isNeedResize($sFilePath = false){
		if($this->bResize == 0){
			/*
			 * Если необходимость ресайза еще не сохранена, то вычисляем её
			 */
			$this->bResize = -1;
			list($sEnableKey,$sWidthKey) = $this->Image_getPreviewConfigKey();
			if(Config::Get($sEnableKey) && Config::Get($sWidthKey)){
				$oImage=$this->CreateImageObject($sFilePath);
				$this->bResize = 1;
				
				/*
				 * Проверяем размеры изображения только, если это требуется
				 */
				if(
					Config::Get('plugin.extentedimage.check_image_width_for_resize')
					&& $oImage->get_image_params('width') <= Config::Get($sWidthKey)
				){
					$this->bResize = -1;
				}
			} 
		}
		
		if($this->bResize > 0){
			return true;
		} else {
			return false;
		}		
	}

	public function isNeedPopup(){
		if(Config::Get('plugin.extentedimage.check_image_width_for_popup')){
			if(!$this->isNeedResize()){
				return false;	
			}
		}
		
		return true;
	}
	
}