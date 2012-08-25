<?php
/**
 * CakePHP Plupload Plugin
 * Pluplaod Component
 * Copyright (c) 2011 junichi11
 *
 * CakePHP version 2.0+
 * PHP version 5.3+
 *
 * @author junichi11
 * @license MIT License
 */
class PluploadComponent extends Component{

	public $components = array('Session', 'RequestHandler');

	/**
	 * setUploaderOptions
	 * @param array $options uploader's option
	 * @return boolean
	 */
	public function setUploaderOptions($options = array()) {
		if (!empty($options)) {
			$this->Session->write('Plupload.Uploader', $options);
			return true;
		}
		return false;
	}

}
?>