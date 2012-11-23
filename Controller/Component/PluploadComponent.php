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

	/**
	 * Upload the file send by Plupload.
	 * @return array - If the all chunk have been uploaded
	 *               - Response (in Json) that can contain error message if error occured
	 *               - Path of the file
	 */
	public function upload() {
		$uploadFinished = false;
		$directory = sys_get_temp_dir();

		$filename = isset($_REQUEST['name']) ? $_REQUEST['name'] : '';
		$currentChunk = isset($_REQUEST['chunk']) ? intval($_REQUEST['chunk']) : 0;
		$nbChunks = isset($_REQUEST['chunks']) ? intval($_REQUEST['chunks']) : 0;

		if (!is_null(env("CONTENT_TYPE"))) {
			$contentType = env("CONTENT_TYPE");
		} elseif (!is_null(env("HTTP_CONTENT_TYPE"))) {
			$contentType = env("HTTP_CONTENT_TYPE");
		}

		$filename = $this->_getUniqueFileName($filename, $directory, $nbChunks);
		$filePath = $directory . DIRECTORY_SEPARATOR . $filename;

		$error = $this->_writeChunkInTempFile($filePath, $currentChunk, $contentType);

		if (is_null($error)) {
			if (!$nbChunks || $currentChunk == $nbChunks - 1) {
				rename("{$filePath}.part", $filePath);
				$uploadFinished = true;
			}
			$response = $this->generateJsonMessage();
		} else {
			$response = $error;
		}

		return array($uploadFinished, $response, $filePath);
	}

	/**
	 * Generate a Json message
	 * @param array Response data
	 * @return string Json
	 */
	public function generateJsonMessage($options = array()) {
		$default = array('jsonrpc' => '2.0', 'result' => null);

		$options = array_merge($default, $options);

		return json_encode($options);
	}

	/**
	 * Return an unique filename if chunking is disabled,
	 * else we return given filename
	 * @param string $filename Original filename
	 * @param string $directory Directory where the file will be write
	 * @param int $nbChunk Number of chunk
	 * @return string A new unique filename if chunking is disabled
	 */
	protected function _getUniqueFileName($filename, $directory, $nbChunks) {
		$newFilename = $filename;

		if ($nbChunks < 2 && file_exists($directory . DS . $filename)) {
			$extentionPosition = strrpos($filename, '.');
			$fileNameWithoutExtention = substr($filename, 0, $extentionPosition);
			$extention = substr($filename, $extentionPosition);

			$count = 0;
			do {
				$newFilename = $fileNameWithoutExtention . '_' . $count . $extention;
				$count++;
			} while (file_exists($directory . DS . $newFilename));
		}
		return $newFilename;
	}

	/**
	 * Write chunk in temp file
	 * @param $tmpFilePath Temp file path
	 * @param $currentChunk Chunk to write
	 * @param $contentType
	 * @return mixe A json error message if an error occured else null
	 */
	protected function _writeChunkInTempFile($tmpFilePath, $currentChunk, $contentType) {
		$error = null;
		$inPath = "php://input";
		$inPathExist = true;

		if (strpos($contentType, "multipart") !== false) {
			$inPath = $_FILES['file']['tmp_name'];
			$inPathExist = isset($_FILES['file']['tmp_name']) && is_uploaded_file($_FILES['file']['tmp_name']);
		}

		if ($inPathExist) {
			$out = fopen("{$tmpFilePath}.part", $currentChunk == 0 ? "wb" : "ab");
			if ($out) {
				$in = fopen($inPath, "rb");

				if ($in) {
					while ($buff = fread($in, 4096)){
						fwrite($out, $buff);
					}
				} else {
					$error = $this->generateJsonMessage(array(
						'error' => array('code' => 101, 'message' => __('Failed to open input stream.'))
					));
				}
				fclose($in);
				fclose($out);
			} else {
				$error = $this->generateJsonMessage(array(
					'error' => array('code' => 102, 'message' => __('Failed to open output stream.'))
				));
			}
		} else {
			$error = $this->generateJsonMessage(array(
				'error' => array('code' => 103, 'message' => __('Failed to move uploaded file.'))
			));
		}

		return $error;
	}
}
?>