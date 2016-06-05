<?php
/**
 * Created by PhpStorm.
 * User: Ravi
 * Date: 4/6/16
 * Time: 7:10 PM
 *
 * It is a homepage file.
 */


require_once(__DIR__ . '/php/Service.php');
require_once(__DIR__ . '/php/utils/Message.php');

/**
 * creating instance of Service class
 */
$service = new Service();

$page = isset($_GET['page']) ? $_GET['page'] : 1;
$tag = isset($_GET['country']) ? $_GET['country'] : 'spain';
$response = $service->search($tag, 5, $page);
$artistArray = $response->topartists->artist;
$totalPages = $response->topartists->{'@attr'}->totalPages; // returns total number of pages
$total = $response->topartists->{'@attr'}->total; // return total images


?>


<!DOCTYPE html  PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"/>
    <link rel="stylesheet" href="../css/common.css"/>
    <link rel="stylesheet" href="../css/homepage.css"/>
    <title>Aussie Ecommerce Technical Test Demo - Ravi Bhavsar</title>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.3.3/angular.min.js"></script>
</head>

<body>

<header class="body-block">
    <h1 align="center">Last FM Gallery</h1>

    <div class='wrap' ng-app='Lookup' ng-controller='LookupCtrl'>
        <span id="country">
        {{selected}}
        <i class='fontawesome-remove' ng-click='clear()' ng-show='selected'></i>
        </span>

        <form class="form-search" action="<?php $_SERVER['PHP_SELF']; ?>" method="get" role="search">
            <input type="search" id="query" placeholder="Search" required ng-change='change()' ng-model='query'
                   value="{{selected}}" autocomplete="off"/>
            <ul class='{{state}}' ng-show='query' id="countryList">
                <li ng-click='select(item)' ng-repeat='item in items | filter: query'>
                    {{item}}
                </li>
            </ul>
            <input type="hidden" name="country" value="{{selected}}"/>
            <input type="submit" value="Search"/>
        </form>
    </div>
</header>

<div class="body-block thumbnails">


    <ul class="thumbnails__list">
        <h2>Artist Gallery</h2>

        <div id="thumbs">

            <?php

            try {

                if (!isset($response->error)) {

                    // loop through each photo
                    foreach ($artistArray as $single_photo) {

                        $artistName = $single_photo->name;
                        $artistMBID = $single_photo->mbid;

                        foreach ($single_photo->image as $imageUrl) {

                            if ($imageUrl->size == 'medium') {
                                $photo_url = $imageUrl->{'#text'};
                                break;

                            } else {
                                $photo_url = $imageUrl->{'#text'};
                            }
                        }

                        $size = 'medium';
                        echo '<li>';
                        echo "<a id=\"thumb_img\" href=\"/php/photo.php?artist=$artistName\" title=\"View $artistName\">";
                        echo "<img src=\"" . $photo_url . "\" width=\"150\" height=\"150\" alt=\"$artistName\" />";
                        echo "</a>";
                        echo '</li>';

                    }

                    if (count($artistArray) == 0) {
                        Message::$zeroResponsePage['message'];
                    }

                } elseif ($response->error == 6) {
                    echo Message::$invalidCountry['message'];
                }

            } catch (Exception $e) {
                echo Message::$operationFailed['message'];
            }
            ?>

        </div>

        <p id="nav">
            <?php
            // Some simple paging code to add Prev/Next to scroll through the thumbnails
            $back = $page - 1;
            $next = $page + 1;

            if ($page > 1) {
                echo "<a href='?country=$tag&page=$back'>&laquo; <strong>Prev</strong></a>";
            }

            if ($totalPages != 0) {
                if ($page != $totalPages) {
                    echo "<a id =\"next\" href='?country=$tag&page=$next' style='margin: 0.5em 0;text-align: right'><strong>Next</strong> &raquo;</a>";
                }
            }
            ?>
        </p>

        <?php

        if ($totalPages != 0) {

            $startPage = $page;
            if (($startPage + 9) > $totalPages) {
                $startPage = $totalPages - 9;
            } elseif (($startPage - 4) <= 0) {
                $startPage = 1;
            } else {
                $startPage = $startPage - 4;
            }
            $pages_html = null;
            for ($i = $startPage; $i < $startPage + 10; $i++) {
                if ($page != $i) {
                    $pages_html .= '<a href="?country=' . $tag . '&page=' . $i . '">' . $i . '</a>&nbsp;';
                } else {
                    $pages_html .= $i . '&nbsp;';
                }
            }

            echo "<div align='center'>";
            echo $pages_html;
            echo "</div>";
        }

        ?>

    </ul>

    <?php
    echo "<div align='center'>";
    if ($totalPages != 0) {
        echo "<p>Page <b style='color: gray'>$page</b> of $totalPages</p>";
        echo "<p><b style='color: brown'>$total</b> Photos in Gallery</p>";
        echo "</div>";
    } else {
        echo "<p><b style='color: brown'>$total</b> Photos found with country " . $tag . "</p>";
    }
    ?>

</div>


<script src="js/home.js"></script>
</body>
</html>








