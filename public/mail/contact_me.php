<?php
// Check for empty fields
if(empty($_POST['name'])      ||
   empty($_POST['email'])     ||
   empty($_POST['message'])   ||
   !filter_var($_POST['email'],FILTER_VALIDATE_EMAIL))
   {
   echo "Certains champs sont vides";
   return false;
   }

$name = strip_tags(htmlspecialchars($_POST['name']));
$email_address = strip_tags(htmlspecialchars($_POST['email']));
$message = strip_tags(htmlspecialchars($_POST['message']));

// Create the email and send the message
$to = 'anaiscen@gmail.com'; // Add your email address here
$email_subject = "Contact blog :  $name";
$email_body = "Vous avez reçu un nouveau message de via votre blog.\n\n"."Détails :\n\nNom: $name\n\nEmail: $email_address\n\nMessage:\n$message";
$headers = "From: anaiscen@gmail.com\n";
$headers .= "Reply-To: $email_address";
mail($to,$email_subject,$email_body,$headers);
return true;
?>
