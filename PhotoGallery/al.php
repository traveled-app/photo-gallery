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

GLOBAL $albumName;
GLOBAL $i;
GLOBAL $n;
GLOBAL $showHome;
GLOBAL $fileList;

init();
showHeader($albumName);
showNextBatch();
showCounter($i, $n, $fileList);
echo($showHome);
albumPage($albumName);
if ($i < count($fileList) - 1) {
	showNextBatch();
}
showAlbum($albumName);
//showNextAlbum();
footer();

// Functions

function init() {
	GLOBAL $albumName;
	$albumName = $_GET['al'];
	GLOBAL $fileList;
	$fileList = getImageList($albumName);
	GLOBAL $i;
	$i = $_GET['i'];	// photo number offset
	GLOBAL $n;
	$n = $_GET['n'];	// photo show count
	if ($i == null) {
		$i = 0;
	}
	if ($n == null) {
		$n = 5;
	}
}

function showThumbnail($filename, $imgnum) {
	echo('<p style="color:lightgray;text-align:center;padding-top: 50px;">');
	// link to photo view page
	GLOBAL $albumName;
	$src = 'ph.php?al='.$albumName.'&i='.$imgnum;
	echo('<a href="' . $src . '">');
	//$style = 'style="width:70%;object-fit:cover;"';
	$style = 'style="width:'.(string)Constants::IMG_WIDTH_MD.';object-fit:cover;"';
	$thumb = Constants::ALBUM_DIR.'/'.$albumName.'/md/'.basename($filename);
	echo('<img src="'.$thumb.'" '.$style.'>');
	echo('</a>');
	echo('</p>');
}

function showHeader($al) {
	$style = '"color:lightgray;text-align:center;padding-top:50px;"';
	echo('<h3 style='.$style.'>"'.$al.'"</h3>');
}
function showCounter($i, $n, $fileList) {
	$numphotos = min($i+$n, count($fileList));
	$style='"text-align:right;padding-right: 30px;color:gray;"';
	echo('<h5 style='.$style.'>'.(string)($i + 1).'-'.(string)($numphotos).' ('.count($fileList).')</h5>');
}

function albumPage($albName) {
	GLOBAL $fileList;
	GLOBAL $i;
	GLOBAL $n;
	$ii = $i;
	while($ii < $i + $n && $ii < count($fileList)) {
		$filename = $fileList[$ii];
		showThumbnail( $filename, $ii );
		$ii += 1;
	}
	echo('<p style="padding-top:40px"/>');
}

function showNextBatch() {
	GLOBAL $i;
	GLOBAL $n;
	GLOBAL $albumName;
	GLOBAL $fileList;
	$href = 'al.php?al='.(string)($albumName).'&i='.(string)($i + $n).'&n='.$n;
	$nextn = $n;
	if ($i < count($fileList) - $n) {
		$nexti = $i + $n;
		if ($i+$n > count($fileList)) {
			$nexti = $i + 1;
			$nextn = count($fileList) - $nexti - 1;
		}
	}
	else if ($i < count($fileList)) {
		//echo('<p>Last Batch</p>');
		return;
	}
	else {
		echo('<p>Underflow Batch</p>');
		return;
	}
	echo('<h5 style="color:lightgray;text-align:right;padding-right: 30px">');
	echo('<a href="'.$href.'" style="color:lightgray">Next ></a>');
	echo('</h5>');
}

function showAlbum($al) {
	$href = 'al.php?al='.$al;
	$href = '"'.$href.'"';
	//$href = 'javascript:history.back(1)';
	$style='"color:lightgray;text-align:right;padding-right: 30px"';
	echo( '<h5 style='.$style.'><a href='.$href.' style="color:lightgray;text-align:right">Album</a></h5>');
}

/*
function showNextAlbum() {
//....	echo('<h4>i'.$i.' n'.$nextn.'nexti'.$nexti.' '.count($fileList).'</h4>');
}
*/

function footer() {
	GLOBAL $showHome;
	echo($showHome);
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
