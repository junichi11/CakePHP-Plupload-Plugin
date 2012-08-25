<?php
/**
 * CakePHP PluploadPlugin
 * PluploadHelper
 * CakePHP version 2.0+
 * PHP version 5.3+
 *
 * 2011 Copyright(c) junichi11
 * @author junichi11
 * @license MIT License
 */
App::uses('AppHelper', 'View/Helper');
class PluploadHelper extends AppHelper {

	public $helpers = array('Html', 'Form', 'Session', 'Js' => array('Jquery'));

/**
 * Look following url.
 * http://www.plupload.com/documentation.php
 */
	public $settings = array(
		'ui' => 'jqueryui',
		'widget_url' => '/plupload/plupload/widget',
		'asset_path' => '/plupload/pl/',
		'locale' => '',

		'runtimes' => 'gears,html5,flash,browserplus,silverlight,html4',
		'url' => "/plupload/plupload/upload",
		'max_file_size' => '30mb',
		'chunk_size' => '10mb',
		'unique_names' => false,
		'resize' => '',
		'filters' => array(
			array('title' => 'Image files', 'extensions' => 'jpg,gif,png'),
		),
		'flash_swf_url' => '/plupload/pl/plupload.flash.swf',
		'silverlight_xap_url' => '/plupload/pl/plupload.silverlight.xap',
		'browse_button' => '',
		'drop_element' => '',
		'container' => '',
		'multipart' => true,
		'multipart_params' => array(),
		'required_features' => '',
		'headers' => '',
		// Queue widget specific option
		'preinit' => '',
		'dragdrop' => '',
		'rename' => true,
		'multiple_queues' => '',
		'urlstream_upload' => '',
	);

	function __construct($View, $settings){
		parent::__construct($View, $settings);
		if(!empty($settings)){
			$this->settings = array_merge($this->settings, $settings);
		}
		if($this->settings['asset_path'] !== '/plupload/pl/'){
			$this->settings['flash_swf_url'] = $this->settings['asset_path'].'plupload.flash.swf';
			$this->settings['silverlight_xap_url'] = $this->settings['asset_path'].'plupload.silverlight.xap';
		}
	}

/**
 * beforRender
 */
	public function beforeRender($layoutFile) {
		parent::beforeRender($layoutFile);
		$session = $this->Session->read('Plupload.Uploader');
		if (!empty($session)) {
			$this->settings = am($this->settings, $session);
		}
		if ($this->settings['asset_path'] !== '/plupload/pl/') {
			$this->settings['flash_swf_url'] = $this->settings['asset_path'] . 'plupload.flash.swf';
			$this->settings['silverlight_xap_url'] = $this->settings['asset_path'] . 'plupload.silverlight.xap';
		}
	}

/**
 * loadAsset
 * Load CSS & JS
 * @param type $widget
 * @param type $option
 */
	public function loadAsset($widget = 'jqueryui', $option = array('inline' => false)) {
		$asset_path = $this->settings['asset_path'];
		$assets = Set::normalize($this->settings['runtimes'], false);
		// gears,html5,flash,browserplus,silverlight,html4
		echo $this->Html->script($asset_path . 'plupload', array('inline' => $option['inline']));
		if (count($assets) > 2) {
			echo $this->Html->script($asset_path . "plupload.full.js", array('inline' => $option['inline']));
		} else {
			foreach ($assets as $asset) {
				echo $this->Html->script($asset_path . "plupload.$asset", array('inline' => $option['inline']));
			}
		}
		if (!empty($this->settings['locale'])) {
			echo $this->Html->script($asset_path . 'i18n/' . $this->settings['locale'], array('inline' => $option['inline']));
		}
		switch ($widget) {
			case 'jquery':
				echo $this->Html->script($asset_path . 'jquery.plupload.queue/jquery.plupload.queue', array('inline' => false));
				echo $this->Html->css($asset_path . 'jquery.plupload.queue/css/jquery.plupload.queue', null, array('inline' => false));
				break;
			case 'jqueryui':
			default:
				echo $this->Html->script($asset_path . 'jquery.ui.plupload/jquery.ui.plupload', array('inline' => false));
				echo $this->Html->css($asset_path . 'jquery.ui.plupload/css/jquery.ui.plupload', null, array('inline' => false));
				break;
		}
	}

/**
 * Get Plupload options
 * @return json
 */
	public function getOptions() {
		$options = Set::filter($this->settings);
		unset($options['widget_url']);
		unset($options['asset_path']);
		unset($options['locale']);
		return $this->Js->object($options);
	}

/**
 * loadWidget
 * @param string $ui widget type
 * @param array $option iframe property
 * -width
 * -height
 * -frameborder
 * -escape
 * @return string <iframe>
 */
	public function loadWidget($ui = 'jqueryui', $option = array()) {
		switch ($ui) {
			case 'jquery':
			case 'jqueryui':
				break;
			default :
				$ui = 'jqueryui';
				break;
		}
		$default = array(
			'width' => '100%',
			'height' => '370px',
			'frameborder' => '0',
			'escape' => false,
			'theme' => '',
		);
		if (!empty($option)) {
			$default = am($default, $option);
		}
		extract($default);
		return $this->Html->tag(
			'iframe',
			'',
			array('src' => Router::url($this->settings['widget_url'] . "/" . $ui, true), 'width' => $width, 'height' => $height, 'frameborder' => $frameborder, 'escape' => $escape)
		);
	}

}