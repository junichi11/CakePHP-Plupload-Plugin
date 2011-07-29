<?php
/**
 * CakePHP Plupload Plugin
 * Plupload Controller
 * 
 * Copyright (c) 2011 junichi11
 * 
 * @author junichi11
 * @license MIT LICENCE
 */
class PluploadController extends PluploadAppController {
	public $name = 'Plupload';
	public $uses = array();
	public $helpers = array('Session', 'Plupload.Plupload');
	public $components = array('Session', 'RequestHandler', 'Plupload.Plupload');

	//===============================================
	// action 
	//===============================================
	public function upload(){
		parent::upload();
		// TODO write upload process e.g. plupload's upload.php
		
	}
	
	public function widget($ui = "jqueryui"){
		$this->set('ui', $ui);
	}
}

?>
