<?php
//ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);
//error_reporting(E_ALL);

//Include Files
include_once("constants.php");
include_once("class_DB.php");

//Connect DB
class_DB::connect();

//Mandatory
echo "Sitemap is updated. ";

//One sitemap file :  50000 records or not more than 50MB

//Sitemap header
header("Content-type: text/xml");

//Create Main Category Sitemap XML Files
$xml_content = "";

$xml_content .='<?xml version="1.0" encoding="UTF-8"?><sitemapindex xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
         xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/siteindex.xsd"
         xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';

$xml_content .='<sitemap>
<loc>'.$baseURL.'test.xml</loc>
<lastmod>'.date("Y-m-d").'</lastmod>
</sitemap>';

$xml_content .='</sitemapindex>';

//Generate Sitemap File
$myfile = fopen($url. "/sitemap.xml", "w+");
fwrite($myfile, $xml_content);
fclose($myfile);
