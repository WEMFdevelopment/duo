<?php

include "lib/gig_functions.php";
include "lib/dev_coder.php";

use DevCoder\DotEnv;
(new DotEnv(__DIR__ . '/.env'))->load();
$jsonData = read_json();
if(isset($_POST['recaptcha_token']) && !empty($_POST['recaptcha_token'])) {
	$reCaptchaToken = $_POST['recaptcha_token'];
	$postArray = array(
		'secret' => getenv('SECRET'),
		'response' => $reCaptchaToken
	);

	$postJSON = http_build_query($postArray);
	$curl = curl_init();
	curl_setopt($curl, CURLOPT_URL, "https://www.google.com/recaptcha/api/siteverify");
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($curl, CURLOPT_POST, 1);
	curl_setopt($curl, CURLOPT_POSTFIELDS, $postJSON);
	$response = curl_exec($curl);
	curl_close($curl);

	$curlResponseArray = json_decode($response, true);

	if($curlResponseArray["success"] == true && $curlResponseArray["score"] >= 0.5) {
		unset($_POST['g-recaptcha-response']);
		unset($_POST['recaptcha_token']);
		unset($_POST['token']);
		unset($_POST['url']);
		$zapierData = array(
			"Dia" => date("d"),
			"Mes" => date("m"),
			"Año" => date("Y"),
			"Date" => date("c", strtotime(date("Y-m-d H:i:s", time() - (6 * 3600)))),
		);

		foreach ($jsonData->url as $urlBlock) {
			$url = 'https://hooks.zapier.com/hooks/catch/'.$urlBlock;
			$data = array_merge($_POST, $zapierData);
			sendToZapier($data, $url);
		}

		echo '<script>window.location = "'. $_POST['domain'] .'/contacto-exitoso.php" </script>';
	} else {
			echo "Please click on the reCAPTCHA 2";
	};
};