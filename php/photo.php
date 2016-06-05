<?php
/**
 * Created by PhpStorm.
 * User: Ravi
 * Date: 4/6/16
 * Time: 8:36 PM
 *
 * This file controls the photo details page.
 */


require_once(__DIR__ . '/Service.php');

$service = new Service();
$artistName = isset($_GET['artist']) ? $_GET['artist'] : NULL;
$responseTracks = $service->getTopTracks($artistName, 5); // Getting top tracks of artist
$responseInfo = $service->getInfo($artistName); //  Getting $artist information

$photo_url = null;
foreach($responseInfo->artist->image as $photo) {
    if(($photo->size == 'mega')) {
        $photo_url = $photo->{'#text'};
        break;
    } else {
        $photo_url = $photo->{'#text'};
    }
}

$description = $responseInfo->artist->bio->summary != '' ? $responseInfo->artist->bio->summary : 'No description is given.';

$previous = "javascript:history.go(-1)";
if(isset($_SERVER['HTTP_REFERER'])) {
    $previous = $_SERVER['HTTP_REFERER'];
}

?>

<!DOCTYPE html  PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"/>
    <title><?php echo $artistName; ?></title>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"/>
    <link rel="stylesheet" href="../css/common.css"/>
    <link rel="stylesheet" href="../css/photo.css"/>
</head>

<body>
<div class="body-block">
    <h2>Artist : <?php echo $artistName; ?></h2>
    <div class="gallery">
        <img src="<?php echo $photo_url; ?>" width="<?php echo $width; ?>" height="<?php echo $height; ?>"
             alt="<?php echo $artistName; ?>"/>
    </div>
    <a href="<?php echo $previous; ?>">Go Back</a>
    <p><b>Description</b> : <?php echo $description; ?></p>
    <p><b>Top 5 tracks</b><br/></p>
    <ul>

    <?php

    foreach($responseTracks->toptracks->track as $track) {
        echo "<li>";
        echo "<a id=\"thumb_img\" href=\"$track->url\" title=\"View $artistName\">";
        echo $track->name;
        echo "</a>";
        echo "</li>";
    }

    ?>

    </ul>
</div>
</body>
</html>