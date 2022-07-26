<?php if(isset($_POST['token'])){ $token = $_POST['token']; }else{  $token=""; }?>
<?php
header('Access-Control-Allow-Origin: *');
ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, 'https://www.googleapis.com/oauth2/v1/tokeninfo?access_token='.$token['access_token']);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
$error_response = curl_exec($ch);
curl_close ($ch);

var_dump($error_response);
$array = json_decode($error_response);
echo "<br/>";
var_dump($array);

// if( isset($array->error)){
//
//   // Generate new Access Token using old Refresh Token
//   $ch = curl_init();
//   curl_setopt($ch, CURLOPT_URL,"https://accounts.google.com/o/oauth2/token");
//   curl_setopt($ch, CURLOPT_POST, TRUE);
//   curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/x-www-form-urlencoded']);
//   curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
//   curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query([
//     'client_id'     => $client_id,
//     'client_secret' => $client_secret,
//     'refresh_token'  => $refresh_token,
//     'grant_type'    => 'refresh_token',
//   ]));
//   curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
//   $response = curl_exec($ch);
//   curl_close ($ch);
// }

?>
