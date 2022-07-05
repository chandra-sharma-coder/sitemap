<?php
//ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);
//error_reporting(E_ALL);

//Include Files
include_once("includes/constants.php");
include_once("includes/class_DB.php");
include_once("includes/class_business.php");
include_once("includes/class_codes.php");
include_once("includes/class_html.php");
include_once("includes/class_merchants.php");
include_once("includes/class_session.php");

//Connect DB
class_DB::connect();

//Get Business by category
$category_data = class_business::getAllCategory();

//Get All Published Coupons
$coupons_data = class_business::getAllCoupons();

//Total Restaurants Sitemap
$total_restaurants = class_business::getAllCatBusiness('f');

//Total Foods Sitemap
$total_foods = class_business::getAllCatBusiness('o');

//Total Things Sitemap
$total_things = class_business::getAllCatBusiness('d');

//Total Shoppings Sitemap
$total_shoppings = class_business::getAllCatBusiness('p');

//File Name Starter
$filename = [
       "f" => "restaurants",
       "o" => "food",
       "d" => "things-to-do",
       "p" => "shopping",
       ];

echo "Sitemap is updated.";

//Sitemap header
header("Content-type: text/xml");

//Sitemap Home Content
$xml_home_content = '<?xml version="1.0" encoding="UTF-8"?><urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd">';

$xml_home_content .='<url>
      <loc>https://www.nearme.cool/</loc>
      <lastmod>'.date("Y-m-d").'</lastmod>
      <priority>1.00</priority>
     </url>

     <url>
      <loc>https://www.nearme.cool/all/1</loc>
      <lastmod>'.date("Y-m-d").'</lastmod>
      <priority>0.80</priority>
      </url>
   
      <url>
      <loc>https://www.nearme.cool/deals-near-me</loc>
      <lastmod>'.date("Y-m-d").'</lastmod>
      <priority>0.80</priority>
      </url>
      
      <url>
      <loc>https://www.nearme.cool/restaurants-near-me</loc>
      <lastmod>'.date("Y-m-d").'</lastmod>
      <priority>0.80</priority>
      </url>
      <url>
      <loc>https://www.nearme.cool/food-near-me</loc>
      <lastmod>'.date("Y-m-d").'</lastmod>
      <priority>0.80</priority>
      </url>
      
      <url>
      <loc>https://www.nearme.cool/things-to-do-near-me</loc>
      <lastmod>'.date("Y-m-d").'</lastmod>
      <priority>0.80</priority>
      </url>
      
      <url>
      <loc>https://www.nearme.cool/shopping-near-me</loc>
      <lastmod>'.date("Y-m-d").'</lastmod>
      <priority>0.80</priority>
      </url>
     
      <url>
      <loc>https://www.nearme.cool/near-me-contact-us</loc>
      <lastmod>'.date("Y-m-d").'</lastmod>
      <priority>0.80</priority>
      </url>
         
      <url>
      <loc>https://www.nearme.cool/about-near-me</loc>
      <lastmod>'.date("Y-m-d").'</lastmod>
      <priority>0.80</priority>
      </url>
      ';

//Subcategories for category
while ($row = mysql_fetch_assoc($category_data)) {

   if(($row['mainCategory'] == 'f') && ($row['status'] != 'd') )
   {
      //restaurants
      $xml_home_content .='<url>
                <loc>'.$baseURL.'restaurants-near-me/1/'.preg_replace('/[^A-Za-z0-9\-]/', '-', strtolower($row['categorySub'])).'</loc>
                <lastmod>'.date("Y-m-d").'</lastmod>
                <category>Restaurants</category>
               </url>';
      
   }elseif(($row['mainCategory'] == 'o') && ($row['status'] != 'd')){
   
    $xml_home_content .='<url>
                <loc>'.$baseURL.'food-near-me/1/'.preg_replace('/[^A-Za-z0-9\-]/', '-', strtolower($row['categorySub'])).'</loc>
                <lastmod>'.date("Y-m-d").'</lastmod>
                <category>Food</category>
               </url>';
   
   }elseif(($row['mainCategory'] == 'd') && ($row['status'] != 'd')){
   
   $xml_home_content .='<url>
                <loc>'.$baseURL.'things-to-do-near-me/1/'.preg_replace('/[^A-Za-z0-9\-]/', '-', strtolower($row['categorySub'])).'</loc>
                <lastmod>'.date("Y-m-d").'</lastmod>
                <category>Things to do</category>
               </url>';
                 
   }elseif(($row['mainCategory'] == 'p') && ($row['status'] != 'd')){
   
   $xml_home_content .='<url>
                <loc>'.$baseURL.'shopping-near-me/1/'.preg_replace('/[^A-Za-z0-9\-]/', '-', strtolower($row['categorySub'])).'</loc>
                <lastmod>'.date("Y-m-d").'</lastmod>
                <category>Shopping</category>
               </url>';
   }
}

$xml_home_content .= '</urlset>';

//Create Main Category Sitemap XML Files
$xml_content = "";

$xml_content .='<?xml version="1.0" encoding="UTF-8"?><sitemapindex xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
         xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/siteindex.xsd"
         xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';

$xml_content .='<sitemap>
<loc>'.$baseURL.'near-me.xml</loc>
<lastmod>'.date("Y-m-d").'</lastmod>
</sitemap>';

for ($i = 1; $i <= count($coupons_data); $i++) {
$xml_content .='<sitemap>
<loc>'.$baseURL.'deals-near-me-'.$i.'-sitemap.xml</loc>
<lastmod>'.date("Y-m-d").'</lastmod>
</sitemap>';
}

for ($i = 1; $i <= $total_restaurants; $i++) {
$xml_content .='<sitemap>
<loc>'.$baseURL.'restaurants-near-me-'.$i.'-sitemap.xml</loc>
<lastmod>'.date("Y-m-d").'</lastmod>
</sitemap>';
}

for ($i = 1; $i <= $total_foods; $i++) {
$xml_content .='<sitemap>
<loc>'.$baseURL.'food-near-me-'.$i.'-sitemap.xml</loc>
<lastmod>'.date("Y-m-d").'</lastmod>
</sitemap>';
}

for ($i = 1; $i <= $total_things; $i++) {
$xml_content .='<sitemap>
<loc>'.$baseURL.'things-to-do-near-me-'.$i.'-sitemap.xml</loc>
<lastmod>'.date("Y-m-d").'</lastmod>
</sitemap>';
}

for ($i = 1; $i <= $total_shoppings; $i++) {
$xml_content .='<sitemap>
<loc>'.$baseURL.'shopping-near-me-'.$i.'-sitemap.xml</loc>
<lastmod>'.date("Y-m-d").'</lastmod>
</sitemap>';
}
$xml_content .='</sitemapindex>';

//Generate home sitemap
$myhome = fopen($root . $roothttp . "/near-me.xml", "w+");
fwrite($myhome, $xml_home_content);
fclose($myhome);

//Generate Sitemap File
$myfile = fopen($root . $roothttp . "/sitemap.xml", "w+");
fwrite($myfile, $xml_content);
fclose($myfile);
