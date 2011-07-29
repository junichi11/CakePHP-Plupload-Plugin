<?php
/**
 * CakePHP Plupload Plugin
 * Pluplaod Component
 * Copyright (c) 2011 junichi11
 * 
 * CakePHP version 1.3+
 * PHP version 5.3+
 * 
 * @author junichi11
 * @license MIT License
 */
class PluploadComponent extends Object{
	
	public $components = array('Session');
	
	//===============================================
	// method
	//===============================================
	/**
	 * setUploaderOptions
	 * @param array $options uploader's option
	 * @return boolean 
	 */
	public function setUploaderOptions($options = array()){
		if(!empty($options)){
			$this->Session->write('Plupload.Uploader', $options);
			return true;
		}
		return false;
	}

}
?>