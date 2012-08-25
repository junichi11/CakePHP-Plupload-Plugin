<?php $this->Plupload->loadAsset($ui);?>
<?php echo $this->Form->create(null, array('type' => 'post', 'action' => 'widget'));?>
	<div id="uploader">
		<p>You browser doesn't have Flash, Silverlight, Gears, BrowserPlus or HTML5 support.</p>
	</div>
<?php echo $this->Form->end();?>
<script type="text/javascript">
$(function() {
	$("#uploader").<?php echo ($ui == 'jquery') ? 'pluploadQueue' : 'plupload';?>(
		<?php echo $this->Plupload->getOptions();?>
	);
	$('form').submit(function($e) {
		var $uploader = $('#uploader').plupload('getUploader');
		if ($uploader.total.uploaded == 0) {
			if ($uploader.files.length > 0) {
				$uploader.bind('UploadProgress', function() {
					if ($uploader.total.uploaded == $uploader.files.length)
						$('form').submit();
				});
				$uploader.start();
			} else{
				alert('You must at least upload one file.');
			}
			$e.preventDefault();
		}
	});
});
</script>