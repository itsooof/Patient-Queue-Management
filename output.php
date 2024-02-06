
<?php  
$filename = "PQM_FACTORS/write.txt";    
$fp = fopen($filename, "r"); 
$contents = fread($fp, filesize($filename)); 
echo '<B><center><div style="font-size:70px;color:white;">PATIENT SEQUENCE</div></center></B>';
echo "<pre><I><center><div style='font-size:30px;color:white;'>$contents</div></center></I></pre>"; 
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require 'PHPMailer-master/src/Exception.php';
require 'PHPMailer-master/src/PHPMailer.php';
require 'PHPMailer-master/src/SMTP.php';
function send_mail($recipient,$subject,$message)
{
$mail = new PHPMailer();
$mail->IsSMTP();
$mail->SMTPDebug  = 0;  
$mail->SMTPAuth   = TRUE;
$mail->SMTPSecure = "tls";
$mail->Port       = 587;
$mail->Host       = "smtp.gmail.com";
//$mail->Host       = "smtp.mail.yahoo.com";
$mail->Username   = "amkuva.lifecare@gmail.com";
$mail->Password   = "ltjrcvjcpoxbvqta";
$mail->IsHTML(true);
$mail->AddAddress($recipient, "recipient-name");
$mail->SetFrom("amkuva.lifecare@gmail.com", "AMKUVA LIFE CARE");
//$mail->AddReplyTo("reply-to-email", "reply-to-name");
//$mail->AddCC("cc-recipient-email", "cc-recipient-name");
$mail->Subject = $subject;
$content = $message;
$mail->MsgHTML($content); 
if(!$mail->Send()) {
//echo "Error while sending Email.";
//var_dump($mail);
return false;
} else {
//echo "Email sent successfully";
return true;
}
}
$file = fopen("mail.txt", "r") or die("Unable to open file!");
$file1 = fopen("PQM_FACTORS/write.txt", "r") or die("Unable to open file!");
while(!feof($file)){
    $error = "";
    $recipient=fgets($file);
    $subject = 'Patient Sequence';
    $message = 'Welcome,<br>'.fgets($file1);
    if(empty($recipient)){
        $error .= "recipient can not be empty<br>";
    }
    if(empty($subject)){
        $error .= "subject can not be empty<br>";
    }
    if(empty($message)){
        $error .= "message can not be empty<br>";
    }
    if($error == "")
    {
        if(send_mail($recipient,$subject,$message))
        {
            $error .= "Message sent!<br>";
        }else
        {
            $error .= "Message NOT sent!<br>";
        }
    }
}
fclose($file);
fclose($file1);
fclose($fp);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        body{
            background-image: url('sign1.png');
            background-repeat: no-repeat;
            background-size: 1540px 1000px;
            width: 100%;  
            height: 100%;
        }
    </style>
</head>
<body>
</body>
</html>