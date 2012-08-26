<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<?php echo $this->Html->charset()?>
	<title>
		<?php __('Plupload'); ?>
	</title>
	<?php
		$pluginWebroot = App::pluginPath('plupload')."webroot/";
		//===============================================
		// meta
		//===============================================
		echo $this->Html->meta('icon');
		//===============================================
		// CSS
		//===============================================
		$pattern = $pluginWebroot."jquery-ui/css/*/*.css";
		$csss = glob($pattern);
		foreach($csss as $css){
			$css = str_replace($pluginWebroot, "", $css);
			echo $this->Html->css('/plupload/'.$css);
		}
		//===============================================
		// javascript
		//===============================================
		$pattern = $pluginWebroot."jquery-ui/js/*.js";
		$scripts = glob($pattern);
		foreach($scripts as $script){
			$script = str_replace($pluginWebroot, "", $script);
			echo $this->Html->script('/plupload/'.$script);
		}
		echo $scripts_for_layout;
	?>
</head>
<body>
	<div id="container">
		<div id="content" class="default">
			<?php echo $this->Session->flash();?>
			<?php echo $content_for_layout; ?>
		</div>
	</div>
<?php $this->Js->writeBuffer();?>
</body>
</html>
