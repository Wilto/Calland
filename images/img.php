<?php
class rwdImage {
	
	function rwdImage($image) {
		$size = GetImageSize($image);
		if(!$image || substr($size['mime'], 0, 6) != 'image/') {
			header('HTTP/1.1 400 Bad Request');
			exit();
		}
	}
	
	function determineType($image) {
		$path_parts = pathinfo($image);
		$ext = strtolower($path_parts["extension"]);
	
		switch ($ext) { 
			case "gif":
				$type = "gif";
				break; 
			case "png":
				$type = "png";
				break; 
			case "jpeg": 
			case "jpg":
				$type = "jpg"; 
				break; 
		}
		return $type;
	}

	function resize($target, $path, $scale, $type) {
		$imageTmp = imagecreatefromstring($target);
	
		list($width, $height) = getimagesize($path);
	
		$xscale = $width * $scale;
		$yscale = $height * $scale;
	
		$imageResized = imagecreatetruecolor($xscale, $yscale);
	
		imagecopyresampled($imageResized, $imageTmp, 0, 0, 0, 0, $xscale, $yscale, $width, $height);
		
		switch($type) {
			case "gif":
				$imageResized = imagegif($imageResized);
				break; 
			case "png":
				$imageResized = imagepng($imageResized);	
				break; 
			case "jpeg": 
			case "jpg":
				$imageResized = imagejpeg($imageResized);
				break; 
			default:
				$imageResized = imagepng($imageResized);
				break;
		}
		return $imageResized;
	}
}
	session_start();
	
	$path	= $_GET['path'];
	$image	= file_get_contents($path);
	$rwd	= new rwdImage($path);
	$type	= $rwd->determineType($path);
	
	if($_SESSION['rwd-viewport']) {
		$view = $_SESSION['rwd-viewport'];
	} else {
		$_SESSION['rwd-viewport'] = $view = $_COOKIE['rwd-viewport'];
	}
	
	if($view == 'large' || !$view) {
		$image = $rwd->resize($image, $path, .25, $type);
	}
	
	header("Cache-Control: private, max-age=10800, pre-check=10800");
	header("Pragma: private");
	header("Expires: " . date(DATE_RFC822, strtotime("1 day")));
	// To prevent hiccups should the user attempt to download the image:
	header('Content-Disposition: Attachment;filename=image.png');
	header("Content-Type: image/$type");
	print $image;
	imagedestroy($image);
?>