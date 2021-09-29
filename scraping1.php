<?php
	
// Function to make GET request using cURL
function curlGet($url) {
  $ch = curl_init();	// Initialising cURL session
  // Setting cURL options
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
  curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
  curl_setopt($ch, CURLOPT_URL, $url);
  $results = curl_exec($ch);	// Executing cURL session
  curl_close($ch);  // Closing cURL session
  return $results;  // Return the results
}
  
$usd_currency_rates = array();  // Declaring array to store the desired data
// Function to return XPath object
function returnXPathObject($item) {
  $xmlPageDom = new DomDocument();	// Instantiating a new DomDocument object
  @$xmlPageDom->loadHTML($item);	// Loading the HTML from downloaded page
  $xmlPageXPath = new DOMXPath($xmlPageDom);  // Instantiating new XPath DOM object
return $xmlPageXPath;	// Returning XPath object
}

$packtPage = curlGet('https://www.ecb.europa.eu/stats/policy_and_exchange_rates/euro_reference_exchange_rates/html/index.en.html');  

$packtPageXpath = returnXPathObject($packtPage); 
$currency = $packtPageXpath->query('///html/body/div[2]/main/div[4]/div[2]/div/div/table/tbody/tr/td[1]/a');  


if ($currency->length > 0) {
  $usd_currency_rates['currency'] = $currency->item(0)->nodeValue;  
}  


$rate = $packtPageXpath->query('//*[@id="main-wrapper"]/main/div[4]/div[2]/div/div/table/tbody/tr/td[3]/a/span'); 
if ($rate->length > 0) {
  $usd_currency_rates['rate'] = $rate->item(0)->nodeValue;  
}  

$filename = 'usd_currency_rates_{date}.csv';
header("Content-type: text/csv");
header("Content-Disposition: attachment; filename=$filename");
$output = fopen("php://output", "w");
$header = array_keys($results[0]);
fputcsv($output. $header);

foreach($results as $column) {
  fputcsv($$output, $column);
}
fclose($output);

print_r($usd_currency_rates);

?>