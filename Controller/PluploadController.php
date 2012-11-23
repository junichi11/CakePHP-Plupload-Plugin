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

/**
 * upload
 */
	public function upload() {
		parent::upload();
		$response = '';
		if (isset($_REQUEST['name'])) {
			list($uploadFinished, $response, $file) = $this->Plupload->upload();

			if ($uploadFinished) {
				$this->getEventManager()->dispatch(new CakeEvent(
					'Plupload.afterFileCompletelyUploaded',
					$this,
					array('file' => $file, 'user' => $this->Auth->user())
				));
			}

			$this->set(compact('response'));
		}
	}

/**
 * widget
 * @param string $ui jquery | jquryui
 */
	public function widget($ui = "jqueryui") {
		$this->set('ui', $ui);
	}

}