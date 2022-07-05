<?php
//ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);
//error_reporting(E_ALL);

//Include Files
include_once("constants.php");
include_once("class_DB.php");

//Mandatory
echo "Sitemap is updated.";

//Sitemap header
header("Content-type: text/xml");

//Sitemap
$xml_content = '<?xml version="1.0" encoding="UTF-8"?><urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd">';

$xml_home_content .='<url>
      <loc>https://www.google.cool/</loc>
      <lastmod>'.date("Y-m-d").'</lastmod>
      <priority>1.00</priority>
     </url>';

$xml_content .= '</urlset>';

//Generate Sitemap File
$myfile = fopen($url."/sitemap.xml", "w+");
fwrite($myfile, $xml_content);
fclose($myfile);
