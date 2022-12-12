<?php
include "lib/gig_functions.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

	if(isset($_POST['g-recaptcha-response']) && !empty($_POST['g-recaptcha-response'])){
		$privatekey = '6Lcy9U8aAAAAALb-DR6GdWY7nrIi90F9RrTJ8SFj';
		$captcha = $_POST['g-recaptcha-response'];
		$url = 'https://www.google.com/recaptcha/api/siteverify';
		$data = array(
				'secret' => $privatekey,
				'response' => $captcha,
				'remoteip' => $_SERVER['REMOTE_ADDR']
		);
	
		$curlConfig = array(
				CURLOPT_URL => $url,
				CURLOPT_POST => true,
				CURLOPT_RETURNTRANSFER => true,
				CURLOPT_POSTFIELDS => $data
		);
	
		$ch = curl_init();
		curl_setopt_array($ch, $curlConfig);
		$response = curl_exec($ch);
		curl_close($ch);
		$jsonResponse = json_decode($response);

		if ($jsonResponse->success == true) {
			$to = "jonathan.vasquez@gig.mx, georgina.gonzalez@gig.mx, saul.gonzalez@gig.mx, indira.santacruz@gig.mx, jcarlos@goodhumans.agency, leonardo@goodhumans.agency";
			
			// $to = "jcarlos@masfusion.com";
			
			$from = $_POST['email'];
			$name = $_POST['nombre'];
			$phone = $_POST['telefono'];

			$comment = $_POST['comentario'];

			$day = $_POST['dia'];
			$month =  $_POST['mes'];
			$year = $_POST['year'];
			$turn = $_POST['turno'];

			$subject = "Duo 24 - ".$_POST['asunto'];

			$html = "<html>
								<body style='margin:0; padding:0;'>
									<h1>GIG | Duo 24</h1>
									<h2>".$subject."</h2>
										<strong>Fecha de contacto:</strong> ". date("d/m/Y H:i") ."<br>
										<strong>Nombre:</strong> " . $name . "<br>
										<strong>Telefono:</strong> " . $phone . "<br>
										<strong>E-mail:</strong> " . $from . "<br>";

			if($_POST['asunto'] == "Contacto") {
					$html.=  "<strong>Comentario:</strong> " . $comment . "<br>";
			};

			if($_POST['asunto'] == "Agendar cita") {
					$html.=  "<strong>Fecha de la cita:</strong> " . $day . "/" . $month . "/" .$year. "<br>";
					$html.=  "<strong>Turno:</strong> " . $turn . "<br>";
			};
			$html.= "</body></html>";

			$headers  = "MIME-Version: 1.0" . "\r\n";
			$headers .= "Content-type: text/html; charset=UTF-8" . "\r\n";
			$headers .= "From:" . $from . "\r\n";
			$headers .= "X-Mailer: PHP/" . phpversion()."\r\n";

			if (mail($to, $subject, $html, $headers)){
				echo "Enviando...";

				$sendData = array(
						"nombre" => $name,
						"apellidoP" => $_POST['apellidoP'],
						"apellidoM" => $_POST['apellidoM'],
						"email" => $from,
						"telefono" => $phone,
						"area" => "DUO_24",
						"plaza"=> "GDV"
				);

				$ch = curl_init('https://gig.mx/gigOdataSend/index.php');
				$payload = json_encode($sendData);
				curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
				curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
				curl_setopt($ch, CURLOPT_USERPWD, "gigSpecialOData:U1Tr4z3CuR3P4zz");
				// $result = curl_exec($ch);
				
				$curl = curl_init();
 
                $mailData = array (
                    "to"      => $to,
                    "subject" => $subject,
                    "text"    => $subject,
                    "html"    => $html
                );
                
                curl_setopt_array($curl, array(
                  CURLOPT_URL => 'https://sendmail.goodhumans.mx/mails/contact',
                  CURLOPT_RETURNTRANSFER => true,
                  CURLOPT_ENCODING => '',
                  CURLOPT_MAXREDIRS => 10,
                  CURLOPT_TIMEOUT => 0,
                  CURLOPT_FOLLOWLOCATION => true,
                  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                  CURLOPT_CUSTOMREQUEST => 'POST',
                  CURLOPT_POSTFIELDS =>json_encode($mailData),
                  CURLOPT_HTTPHEADER => array(
                    'Content-Type: application/json'
                  ),
                ));
                
                $response = curl_exec($curl);
                
                curl_close($curl);

				$zapierData = array(
					"Nombre" => $name,
					"Teléfono" => $phone,
					"Correo" => $from,
					"Desarrollo" => "DUO_24",
					"Dia" => date("d"),
					"Mes" => date("m"),
					"Año" => date("Y"),
					"Date" => date("c", strtotime(date("Y-m-d H:i:s", time() - (6 * 3600)))),
				);
				sendToZapier($zapierData);

				header('Location: gracias.html');
				echo '<script>window.location = "gracias.html" </script>';
				
			}else{
					header('location: contacto-fallido.php');
			};

		}else {
				$errMsg = 'Robot verification failed, please try again.';
				echo "<script>alert(\"KO ROBOT\")</script>";
			}
	}
	else{
		$errMsg = 'Please click on the reCAPTCHA box.';
			echo "<script>alert(\"KO CLICK ON BOX\")</script>";
	}									
}
?>
