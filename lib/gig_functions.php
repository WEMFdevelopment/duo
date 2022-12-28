 <?php

function read_json() {
	$json = file_get_contents('./json/gig_json.json');
	return json_decode($json);
}

/******** Sections ********/

// Home
function get_header() {
	$json = read_json();
	$header = $json->home->header;
	return $header;
}

function get_amenities() {
	$json = read_json();
	$amenities = $json->home->amenities;
	return $amenities;
}

// Gallery

function get_amenities_photos() {
	return get_amenities();
}

function get_prototypes_photos() {
	$json = read_json();
	$prototypes = $json->gallery->prototypes;
	return $prototypes;
}

function get_others_photos() {
	$json = read_json();
	$others = $json->gallery->others;
	return $others;
}

/******** General functions ********/

function get_summary_prototypes() {
	$json = read_json();
	$prototypes =  $json->prototypes;
	return $prototypes;
}

function get_promotions() {
	$json = read_json();
	$promotions =  $json->promotions;
	return $promotions;
}

function validate_prototype($prototype) {
	$prototypes = get_summary_prototypes();
	$valid = false;

	foreach ($prototypes as $obj) {
		if($obj->key == $prototype){
			$valid = true;
			break;
		}
	}

	return $valid;
}

function get_current_prototype($key) {
	$prototypes = get_summary_prototypes();
	$current_prototype = (object) array();
	foreach ($prototypes as $obj) {
		if($obj->key == $key){
			$current_prototype = $obj;
			break;
		}
	}
	return $current_prototype;
}

function getBaseURL() {
	$baseURL = (@$_SERVER["HTTPS"] == "on") ? "https://" : "http://";
    $baseURL .= $_SERVER["SERVER_NAME"];
    if($_SERVER["SERVER_PORT"] != "80" && $_SERVER["SERVER_PORT"] != "443") {
        $baseURL .= ":".$_SERVER["SERVER_PORT"];
    } 
    return $baseURL;
}

function getCurrentURL() {
	$currentURL = getBaseURL() ;
    $currentURL .= $_SERVER["REQUEST_URI"];
    return $currentURL;
}

function getEmails() {
	$json = read_json();
	$emails = $json->emails;
	return $emails;
}

function sendToZapier($data, $url){
	$ch = curl_init($url);
	$payload = json_encode($data);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
	curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	$result = curl_exec($ch);
	curl_close($ch);
}

?>