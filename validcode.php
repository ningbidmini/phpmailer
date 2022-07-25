<?php if(isset($_POST['code'])){ $code = $_POST['code']; }else{  $code=""; }?>
<?php if(isset($_POST['clientID'])){ $clientID = $_POST['clientID']; }else{  $clientID=""; }?>
<?php if(isset($_POST['redirecturl'])){ $redirecturl = $_POST['redirecturl']; }else{  $redirecturl=""; }?>
<?php if(isset($_POST['clientsecret'])){ $clientsecret = $_POST['clientsecret']; }else{  $clientsecret=""; }?>
<?php
$headers = array('Content-Type: application/json');

$dataset = array(
  'code'          => $code,
  'client_id'     => $clientID,
  'client_secret' => $clientsecret,
  'redirect_uri'  => $redirecturl,
  'grant_type'    => 'authorization_code',
);
echo '<pre>';
// var_dump($dataset);
// exit;
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL,"https://accounts.google.com/o/oauth2/token");
    curl_setopt($ch, CURLOPT_POST, TRUE);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($dataset));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 0);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);

    $response = curl_exec($ch);
    curl_close ($ch);
    // var_dump($response);
    echo $response;
?>
