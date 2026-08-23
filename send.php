<?php
declare(strict_types=1);
function fail(string $msg, int $code=400): never { http_response_code($code); echo '<!doctype html><html lang="de"><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title>Kontakt</title><style>@import url("https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600&family=Playfair+Display:ital,wght@0,500;1,500&display=swap");h1{font-family:"Playfair Display",Georgia,serif;font-weight:500;letter-spacing:-.02em}</style><body style="font-family:"DM Sans",Arial,sans-serif;max-width:700px;margin:60px auto;padding:20px"><h1>Nachricht nicht gesendet</h1><p>'.htmlspecialchars($msg, ENT_QUOTES, 'UTF-8').'</p><p><a href="kontakt.html">Zurück zum Kontaktformular</a></p></body></html>'; exit; }
if ($_SERVER['REQUEST_METHOD'] !== 'POST') fail('Ungültige Anfrage.', 405);
if (!empty($_POST['website'] ?? '')) { http_response_code(204); exit; }
$name=trim((string)($_POST['name']??'')); $email=trim((string)($_POST['email']??'')); $phone=trim((string)($_POST['phone']??'')); $subject=trim((string)($_POST['subject']??'')); $message=trim((string)($_POST['message']??''));
if (!isset($_POST['privacy']) || $_POST['privacy']!=='1') fail('Bitte bestätigen Sie die Datenschutzerklärung.');
if ($name==='' || $subject==='' || $message==='' || !filter_var($email,FILTER_VALIDATE_EMAIL)) fail('Bitte prüfen Sie die Pflichtfelder und Ihre E-Mail-Adresse.');
if (mb_strlen($name)>100 || mb_strlen($email)>160 || mb_strlen($phone)>50 || mb_strlen($subject)>120 || mb_strlen($message)>2000) fail('Eine Eingabe ist zu lang.');
$cleanSubject=preg_replace('/[\r\n]+/',' ', $subject); $cleanEmail=preg_replace('/[\r\n]+/','', $email);
$to='info@zmk-gruenenplan.de';
$mailSubject='Website-Anfrage: '.$cleanSubject;
$body="Neue Kontaktanfrage über zmk-gruenenplan.de\n\nName: $name\nE-Mail: $cleanEmail\nTelefon: $phone\nBetreff: $cleanSubject\n\nNachricht:\n$message\n";
$headers=['From: Website ZMK Grünenplan <website@zmk-gruenenplan.de>','Reply-To: '.$cleanEmail,'Content-Type: text/plain; charset=UTF-8'];
if (!mail($to,$mailSubject,$body,implode("\r\n",$headers))) fail('Der Versand ist auf diesem Server derzeit nicht möglich. Bitte kontaktieren Sie uns telefonisch oder per E-Mail.',500);
echo '<!doctype html><html lang="de"><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title>Vielen Dank</title><style>@import url("https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600&family=Playfair+Display:ital,wght@0,500;1,500&display=swap");h1{font-family:"Playfair Display",Georgia,serif;font-weight:500;letter-spacing:-.02em}</style><body style="font-family:"DM Sans",Arial,sans-serif;max-width:700px;margin:60px auto;padding:20px"><h1>Vielen Dank.</h1><p>Ihre Nachricht wurde versendet. Wir melden uns schnellstmöglich zurück.</p><p><a href="index.html">Zur Startseite</a></p></body></html>';
