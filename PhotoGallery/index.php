<html>
<head>
</head>
<body style="background-color:black;">
<meta name="HandheldFriendly" content="true" />
<meta name="MobileOptimized" content="320" />
<meta name="viewport" content="initial-scale=1.0, maximum-scale=1.0, width=device-width, user-scalable=no" />

<?
// Main entry point

require "config.php";

init();
showHeader();
showAlbums();
footer();

// Functions

function init() {
}

function showHeader() {
	echo('<h2 style="color:lightgray;text-align:center;padding-top: 60px;padding-bottom:60px;">Galleries</h2>');
}

function footer() {
	echo('<p style="text-align:right;padding-right: 30px"><sup style="color:gray;">Copyright 2021</sup></p>');
}

function showAlbumCover($albumName) {
	// show image caption
	echo('<h4 style="color:lightgray;text-align:center;">');
	echo('<sup style="color:lightgray;text-align:center;">'.$albumName.'</sup>');
	echo('</h4>');

	// show thumbnail in link to photo page
	$href = 'al.php?al='.$albumName.'&i=0&n=5';
	echo('<p style="color:lightgray;text-align:center;padding-bottom:60px">');
	echo('<a href="' . $href . '">');

	// show image thumbnail
	//$style = 'style="width:50%;object-fit:cover;"';
	$style = 'style="width:'.(string)Constants::IMG_WIDTH_SM.';object-fit:cover;"';
	$src = Constants::ALBUM_DIR.'/'.$albumName.'/cv/cv.jpg';
	echo('<img '.$style.' src="'.$src.'">');
	echo('</a>');
	echo('</p>');
}

function showAlbums() {
	$g = Constants::ALBUM_DIR.'/*';
	$fileList = glob( $g );
	foreach($fileList as $filename) {
		showAlbumCover(basename($filename));
	}
}

?>

</body>
</html>
