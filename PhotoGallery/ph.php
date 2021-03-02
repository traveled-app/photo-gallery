<html>
<head>
</head>
<body style="background-color:black;">
<meta name="HandheldFriendly" content="true" />
<meta name="MobileOptimized" content="320" />
<meta name="viewport" content="initial-scale=1.0, maximum-scale=1.0, width=device-width, user-scalable=no" />

<?
require "config.php";

// Main entry point

GLOBAL $al;
GLOBAL $iQuery;
GLOBAL $imageList;

init();
showPhoto($al, $iQuery, $imageList);
showNextPhoto($al, $iQuery, $imageList);
showAlbum($al, $iQuery, $imageList);
showFooter();

// Functions

function init() {
		// get query args
		GLOBAL $al;
		$al = $_GET['al'];
		GLOBAL $iQuery;
		$iQuery = $_GET['i'];
		if ($iQuery == Null) {
			$iQuery = 0;
		}
		GLOBAL $imageList;
		$imageList = getImageList($al);
}

// Show photo at full resolution.  On tap, back up browser.

function showPhoto($al, $iQuery, $imageList) {

	$src = 'ph.php?al='.$al.'&i='.$iQuery;
	$href = 'javascript:history.back(1)';

	echo('<a href="' . $href . '">');
	$photoSrc = Constants::ALBUM_DIR.'/'.$al.'/'.$imageList[$iQuery];
	$style = 'style="width:100%;object-fit:cover;padding-top:10px"';
	echo('<img '.$style.' src="' . $photoSrc . '"/>');
	echo('</a>');

	echo('<p style="padding-left:10px;padding-top:30px">');
	echo('<sup style="color:lightgray;">'.$imageList[$iQuery].'</sup><br/>');
	$size = getimagesize ( $photoSrc );
	if ($size) {
		$width = $size[0];
		$height = $size[1];
		echo('<sup style="color:lightgray;">'.$width.'x'.$height.'</sup>');
	}
	echo('</p>');
}

function showAlbum($al, $iQuery) {
	$href = 'al.php?al='.$al;
	$href = '"'.$href.'"';
	//$href = 'javascript:history.back(1)';
	$style='"color:lightgray;text-align:right;padding-right: 30px"';
	echo( '<h5 style='.$style.'><a href='.$href.' style="color:lightgray;text-align:right">Album</a></h5>');
}

function showNextPhoto($al, $iQuery, $imageList) {
	if ($iQuery < count($imageList)-1) {
		// link to next photo
		$imageName = $imageList[$iQuery + 1];
		$p = 'ph.php?&al='.$al.'&i='.(string)($iQuery+1);
		echo('<h5 style="text-align:right;padding-right: 30px"><a href="' . $p . '" style="color:lightgray">Next ></a></h5>');
	}
	if ($iQuery > 0) {
		// Previous
		$imageName = $imageList[$iQuery - 1];
		$p = 'ph.php?&al='.$al.'&i='.(string)($iQuery-1);
		echo('<h5 style="text-align:right;padding-right: 30px"><a href="' . $p . '" style="color:lightgray"><  Prev</a></h5>');
	}
}

function showFooter() {
	$style = 'width:100%;color:lightgray;padding-left:8px;padding-right:28px;padding-top:10';
	echo('<table style='.$style.'>');
	echo('<tr>');
	echo('<td><sup>📸</sup></td>');
    echo('<td style="text-align:right"><sup>Copyright 2021</sup></td>');
	echo('</tr>');
	echo('</table>');
}

?>
</body>
</html>
