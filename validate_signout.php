<?php if(isset($_POST['token'])){ $token = $_POST['token']; }else{  $token=json_encode(array()); }?>
<?php
header('Access-Control-Allow-Origin: *');
ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);

$datatoken = json_decode($token);
$token = array();
foreach ($datatoken as $key => $value) {
  $token[$key]=$value;
}

$apikey='AIzaSyDSr5icH2KrI_YEZKSXQ-iZW973y9u1jLU';

$status = array();
$status['status']=false;

if(count($token)>0){
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL, 'https://www.googleapis.com/oauth2/v1/tokeninfo?access_token='.$token['access_token']);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
  $error_response = curl_exec($ch);
  curl_close ($ch);

  // var_dump($error_response);
  $array = json_decode($error_response);
  // echo "<br/>";
  echo '<pre>';
  var_dump($array);
  //
  // echo json_encode($status);
}


// $mailname =

// curl_setopt_array($curl, array(
//  CURLOPT_URL => 'https://admin.googleapis.com/admin/directory/v1/users/'.$maildelete,
//  CURLOPT_RETURNTRANSFER => true,
//  CURLOPT_ENCODING => '',
//  CURLOPT_MAXREDIRS => 10,
//  CURLOPT_TIMEOUT => 0,
//  CURLOPT_FOLLOWLOCATION => true,
//  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
//  CURLOPT_CUSTOMREQUEST => 'DELETE',
//  // CURLOPT_POSTFIELDS =>$setstr,
//  CURLOPT_HTTPHEADER => array(
//    'Authorization: Bearer '.$access_token.'',
//   'Content-Type: application/json',
//  ),
// ));

// $response = curl_exec($curl);
//
// curl_close($curl);
//
// echo json_encode($status);
?>
