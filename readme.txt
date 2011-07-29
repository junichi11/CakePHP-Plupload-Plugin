------------------------------------------------------
 日本語
------------------------------------------------------
プラグインをapp/plugins/pluploadに置きます。

jQueryUIとpluploadをダウンロードしてきて展開します。
それぞれ、jquery-ui, pl(plupload/js -> plupload/pl)にrenameし、次のパスに置きます。
plugins/plupload/webroot/jquery-ui
plugins/plupload/webroot/pl

pluploadのアップロード処理を使いたい場合は、
pluploadのupload.phpの処理を、PluploadContorllerのuploadアクションに追記します。

■日本語化
https://gist.github.com/943382
 /path/to/pl/i18n/ja.js

■使い方
□Contoller側
class HogeController extends AppController{
	public $components = array('Plupload.Plupload');
	public $helpers = array('Plupload.Plupload');
	function add($id = null){
		$this->Plupload->setUploaderOptions(array(
			'locale' => 'ja',
			'runtimes' => 'html5',
//			'widget_url' => '/plupload/plupload/widget',
//			'url' => '/plupload/plupload/upload',
			'multipart_params' => array(
				'data[Image][model]' => 'Gallery',
				'data[Image][foreign_key]' => $id,
			)
		));
	}
}

□view側
<?php echo $this->Plupload->loadWidget('jqueryui', array('height' => '550px')); ?>
