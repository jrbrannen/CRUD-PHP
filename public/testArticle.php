<?php

require_once("../inc/NewsArticles.class.php");

$test = new NewsArticles();

// var_dump($test);

var_dump($test->load(1));

?>