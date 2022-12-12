<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');

if(isset($_REQUEST['enviar'])) {
    include("class.phpmailer.php");
     
    extract($_REQUEST);

    $titulo = "Dúo24 Web";

    if(isset($formulario) && $formulario =="lateral"){
        $titulo .= "*";
    }
     
    $mail = new phpmailer();     
    $mail->From = "mkt@duo24.mx";
    $mail->FromName = "Duo24 Web"; 
    $mail->Subject = "Nuevo mensaje de contacto"; 

    $mail->AddAddress("lorena.sanchez@gig.mx");
    $mail->AddAddress("georgina.gonzalez@gig.mx");
    $mail->AddAddress("indira.santacruz@gig.mx");
    $mail->AddAddress("nayeli.cortes@gig.mx");

    $mail->AddReplyTo ("$correo");
    $mail->Body = "
    <div style='width:100%;margin:0;padding:0;background-color:#f5f5f5;font-family:Helvetica,Arial,sans-serif' marginheight='0' marginwidth='0'>
        <div style='display:block;min-height:5px;background-color:#f18533'></div>
        <center>
        <table width='100%' height='100%' cellspacing='0' cellpadding='0' border='0'>
            <tbody>
                <tr>
                <td valign='top' align='center' style='border-collapse:collapse;color:#54a3bd'>
                    <table width='85%' cellspacing='0' cellpadding='0' border='0'>
                        <tbody>
                            <tr>
                                <td valign='top' height='20' align='center' style='border-collapse:collapse;color:#54a3bd'></td>
                            </tr>
                            <tr>
                                <td valign='top' align='center' style='border-collapse:collapse;color:#54a3bd'>
                                    <table width='100%' border='0'>
                                        <tbody>
                                            <tr>
                                                <td height='34' style='border-collapse:collapse;color:#54a3bd'></td> 
                                            </tr>
                                            <tr>
                                                <td align='center' style='border-collapse:collapse;color:rgb(82,82,82);font-family:Helvetica,Arial,sans-serif;font-size:30px;font-weight:bold;line-height:120%;text-align:center' colspan='3'>
                                                    $titulo
                                                </td>
                                            </tr>
                                            <tr>
                                                <td align='center' style='border-collapse:collapse;color:#54a3bd;font-size:15px' colspan='3'></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                
                                </td>
                            </tr>
                            <tr>
                                <td height='38' align='center' style='border-collapse:collapse;color:#54a3bd'></td>
                            </tr>
                            <tr>
                                <td>
                                    <table width='100%' style='border-spacing:0px'>
                                        <tbody>
                                            <tr valign='middle'>
                                                <td width='100%' valign='middle' align='left' style='border-collapse:collapse;color:#54a3bd;padding:10px;background-color:rgb(255,255,255);border-color:rgb(221,221,221);border-width:1px;border-bottom-left-radius:5px;border-bottom-right-radius:5px;border-style:solid;font-size:12px;padding:40px!important;vertical-align:middle'>
                                                    <table cellspacing='0' cellpadding='5px' border='0'>
                                                        <tbody>
                                                            <tr>
                                                                <td style='border-collapse:collapse;color:#54a3bd;padding-right:15px'><b style='color:#888;font-size:10px;text-transform:uppercase'>NOMBRE</b></td>
                                                                <td style='border-collapse:collapse;color:#54a3bd'>$nombre</td>
                                                            </tr>
                                                            <tr>
                                                                <td style='border-collapse:collapse;color:#54a3bd;padding-right:15px'><b style='color:#888;font-size:10px;text-transform:uppercase'>EMAIL</b></td>
                                                                <td style='border-collapse:collapse;color:#54a3bd'><a target='_blank' href='mailto:$correo'>$correo</a></td>
                                                            </tr>
                                                            <tr>
                                                                <td style='border-collapse:collapse;color:#54a3bd;padding-right:15px'><b style='color:#888;font-size:10px;text-transform:uppercase'>TELEFONO</b></td>
                                                                <td style='border-collapse:collapse;color:#54a3bd'>$telefono</td>
                                                            </tr>
                                                            <tr>
                                                                <td style='border-collapse:collapse;color:#54a3bd;padding-right:15px'><b style='color:#888;font-size:10px;text-transform:uppercase'>Presupuesto</b></td>
                                                                <td style='border-collapse:collapse;color:#54a3bd'>$presupuesto</td>
                                                            </tr>
                                                            <tr>
                                                                <td style='border-collapse:collapse;color:#54a3bd;padding-right:15px'><b style='color:#888;font-size:10px;text-transform:uppercase'>Mensaje</b></td>
                                                                <td style='border-collapse:collapse;color:#54a3bd'>$mensaje</td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </td>
                            </tr>
                            <tr>
                                <td valign='top' height='33' align='center' style='border-collapse:collapse;color:#54a3bd'></td>
                            </tr>
                        
                        </tbody>
                    </table>
                </td>
                </tr>
            </tbody>
        </table>
        </center>
        </div>
    ";
    
    $mail->IsHTML(true);
    $enviar = $mail->Send();


    header("Location: ./gracias.html");
    exit;
}
?>

<pre><?php print_r($mail); ?></pre> 
