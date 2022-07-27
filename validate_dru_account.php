<?php if(isset($_POST['token'])){ $token = $_POST['token']; }else{  $token=json_encode(array()); }?>
<?php if(isset($_POST['maxresult'])){ $maxresult = $_POST['maxresult']; }else{  $maxresult=""; }?>
<?php if(isset($_POST['search'])){ $search = $_POST['search']; }else{  $search=""; }?>
<?php
header('Access-Control-Allow-Origin: *');
ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
// echo 'Begin';
// var_dump($token);
$datatoken = json_decode($token);
$token = array();
foreach ($datatoken as $key => $value) {
  $token[$key]=$value;
}
$status = array();
$status['status']=false;


if(count($token)>0){
  $apikey='AIzaSyDSr5icH2KrI_YEZKSXQ-iZW973y9u1jLU';
  $headers = array(
    'Authorization: Bearer '.$token['access_token'].'',
    'Content-Type: application/json',
  );
  if(empty($search)==false){
    $dataquery = "&query=email:".$search;
  }
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL, 'https://admin.googleapis.com/admin/directory/v1/users?domain=dru.ac.th&maxResults='.$maxresult.'&key='.$apiKey);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
  curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
  $error_response = curl_exec($ch);
  curl_close ($ch);

  // var_dump($error_response);
  $array = json_decode($error_response);
  // echo "<br/>";
  // var_dump($array);
  //
  // echo json_encode($status);
}

echo json_encode($status);
?>
