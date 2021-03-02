<?php

// Global variables

Class Constants {
	const VER = 3.14;
	const ALBUM_DIR = "../al";
	const IMG_WIDTH_SM = 200;
	const IMG_WIDTH_MD = 300;
}

$showHome = '<h5 style="text-align:right;padding-right: 30px;"><a href="index.php" style="color:lightgray;text-align:right">Gallery Home</a></h5>';
$buttonStyle = '"color:lightgray;text-align:center;padding-top:50px;"';

class Config {
    public $imgWidthSmall;
	public $albumDir;
}

function getImageList($albumName) {
	$xfileList = glob( Constants::ALBUM_DIR.'/'.$albumName.'/*');
	$fileList = array();
	foreach( $xfileList as $filename) {
		if (is_file($filename)) {
			$sz = getimagesize($filename);
			if ($sz) {
				array_push($fileList, basename($filename));
			}
		}
	}
	return $fileList;
}

?>
