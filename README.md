# CakePHP Plupload Plugin

## Download
* CakePHP Plupload Plugin
* jQueryUI
* plupload

## Settings
* Put this plugin app/Plugin/Plupload
* Put jquery-ui Plugin/Plupload/webroot/jquery-ui
* Put pl(rename plupload/javascript -> plupload/pl) Plugin/Plupload/webroot/pl

## Add upload action
Add upload.php process to PluploadController upload action.

## Language
use /pl/i18n/ja.js (if you want to use Japanese)

Please set as follows.

    $this->Plupload->setUploaderOptions(array(
        'locale' => 'ja',
        ...,
    );

## Usage

### Contoller

    class HogeController extends AppController{
	    public $components = array('Plupload.Plupload');
    	public $helpers = array('Plupload.Plupload');
    	public function add($id = null){
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

### View

    <?php echo $this->Plupload->loadWidget('jqueryui', array('height' => '550px')); ?>
