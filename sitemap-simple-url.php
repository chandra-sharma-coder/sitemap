<?php 

//Fetch Data
public function getTopic() {	
	
	$sqlQuery = "SELECT * FROM ".$this->topicTable;			
	$stmt = $this->conn->prepare($sqlQuery);			
	$stmt->execute();
	$result = $stmt->get_result();
	return $result;
}	

//Create SEO Friendly Url
public function createSeoUrl($id, $subject){    
	$subject = trim($subject);    
	$subject = html_entity_decode($subject);    
	$subject = strip_tags($subject);    
	$subject = strtolower($subject);    
	$subject = preg_replace('~[^ a-z0-9_.]~', ' ', $subject);    
	$subject = preg_replace('~ ~', '-', $subject);    
	$subject = preg_replace('~-+~', '-', $subject);        
	return $subject.'-'.$id;
}

$topicObj = new Topic($db);

$topics = $topicObj->getTopic();

$baseUrl = 'http://localhost/demo_sitemap/xml/'; 

$xml_content = '';

$xml_content .= '<?xml version="1.0" encoding="UTF-8"?>';

$xml_content .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" 
xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" 
xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9 
http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd">';

while ($topic = $topics->fetch_assoc()) {

	$url = $topicObj->createSeoUrl($topic['id'], $topic['subject']);
  
	$date = str_replace('/', '-', $topic['created']);
  
	$xml_content .= '<url>';
	$xml_content .= '<loc>'.$baseUrl.$url.'</loc>';
	$xml_content .= '<lastmod>'.date("Y-m-d", strtotime($date)).'T'.date("H-i-s", strtotime($date)).'Z</lastmod>';
	$xml_content .= '</url>';
}

$xml_content .='</urlset>';

//Generate Sitemap File
$myfile = fopen($baseUrl."/sitemap.xml", "w+");
fwrite($myfile, $xml_content);
fclose($myfile);
?>


