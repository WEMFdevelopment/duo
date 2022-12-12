<?php
//if(isset($_POST['nombre'])) {

    // EDIT THE 2 LINES BELOW AS REQUIRED
    $email_to = "marketing@grupo2g.mx";
    $from = "mkt@grupo2g.mx";
    $email_subject = "Contacto DUO 24";

    function died($error) {
        // your error code can go here
        echo "Lo sentimos, se encontraron errores al enviar el formulario. ";
        echo "Dichos errores aparecen a continuación.<br /><br />";
        echo $error."<br /><br />";
        echo "Por favor, intente de nuevo.<br /><br />";
        die();
    }


    // validation expected data exists
    if(!isset($_POST['nombre']) || !isset($_POST['email']) || !isset($_POST['telefono']) || !isset($_POST['fecha']) ) {
        died('Lo sentimos, parece que hubo un error durante el envío del formulario.');
    }



    $first_name = $_POST['Nombre']; // required
    $email_from = $_POST['email']; // required
    $telephone = $_POST['Telefono']; // not required
    $date = $_POST['fecha']; // required


    $error_message = "";
    $email_exp = '/^[A-Za-z0-9._%-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,4}$/';

  if(!preg_match($email_exp, $email_from)) {
    $error_message .= 'La dirección de correo introducida no es válida.<br />';
  }

  $string_exp = "/^[A-Za-z .'-]+$/";

  if(!preg_match($string_exp, $first_name)) {
    $error_message .= 'The First you entered does not appear to be valid.<br />';
  }

  /*if(!preg_match($string_exp,$date)) {
    $error_message .= 'The Last Name you entered does not appear to be valid.<br />';
  }*/

  /*if(strlen($comments) < 2) {
    $error_message .= 'The Comments you entered do not appear to be valid.<br />';
  }*/

  if(strlen($error_message) > 0) {
    died($error_message);
  }

    $email_message = "Se ha agendado una cita para proyecto DUO 24.\n\n";


    function clean_string($string) {
      $bad = array("content-type","bcc:","to:","cc:","href");
      return str_replace($bad,"",$string);
    }

    $email_message .= "Nombre: ".clean_string($first_name)."\n";
    $email_message .= "E-mail: ".clean_string($email_from)."\n";
    $email_message .= "Telefono: ".clean_string($telephone)."\n";
    $email_message .= "Fecha de la cita: ".clean_string($date)."\n";
    //$email_message .= "Comments: ".clean_string($comments)."\n";

// create email headers
// $headers = 'From: '.$email_to."\r\n".
$headers = 'From: '.$from."\r\n".
'Reply-To: '.$email_to."\r\n" .
'X-Mailer: PHP/' . phpversion();
//@mail($from, $email_subject, $email_message, $headers);
@mail($email_to, $email_subject, $email_message, $headers);
if(mail($email_to, $email_subject, $email_message, $headers)){
    $data = "Gracias por contactarnos.";
    header('Content-Type: application/json');
    echo json_encode($data);
}
//}
?>