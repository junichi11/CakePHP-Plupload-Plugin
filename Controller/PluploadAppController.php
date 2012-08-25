<?php
/**
 * CakePHP Plupload Plugin
 * Plupload PluploadAppController
 *
 * Copyright (c) 2011 junichi11
 *
 * @author junichi11
 * @license MIT LICENCE
 */
class PluploadAppController extends AppController {

	public $components = array('Session', 'Plupload.Plupload', 'RequestHandler');

	public $helpers = array('Session', 'Plupload.Plupload', 'Js' => array('Jquery'));

	public function upload() {
		if (!$this->RequestHandler->isPost()) {
			$this->redirect('/');
			exit();
		}
		$this->layout = false;
		$this->disableCache();
	}

}