<?php if(isset($_POST['token'])){ $token = $_POST['token']; }else{
  $token=json_encode(array(
    'access_token'=>'ya29.A0AVA9y1uE85y7xwgBL9mQbnF81chNVrqjZx1oBKJ_6W7ccHdRpvPQ6XER3TEv9mtltUGN-camaotuhUHWlWMIE3NRVJiqO7tMCHwo-Y_fSiQRtW2G1xbupNxpjxSwMxBazO3gzzKX4zU4L-egnBMLJgB1cNRTYUNnWUtBVEFTQVRBU0ZRRTY1ZHI4ZXhpOVFCSVE3YU4tYlVuOU9ocDd6UQ0163',
  ));
}?>
<?php if(isset($_POST['dataset'])){ $dataset = $_POST['dataset']; }else{
  $dataset=json_encode(array(
    'password'=>'T87654321',
    'primaryEmail'=>'tossapol.xc@dru.ac.th',
    'name'=>array(
      'familyName'=>'testx',
      'givenName'=>'testxxx',
    ),
  ));
}?>
<?php

$newset = array();
$getdata=json_decode($dataset);
foreach ($getdata as $key => $value) {
  // if(gettype($value)==''
  // echo $value;
  // echo gettype($value);
  switch (gettype($value)) {
    case 'string':
      $newset[$key]=$value;
    break;
    case 'object':

      $newobject = $value;

      foreach ($newobject as $keyone => $valueone) {
        $newset[$key][$keyone]=$valueone;
      }
    break;
  }
}



$datatoken = json_decode($token);
// var_dump($datatoken);
$token = array();
foreach ($datatoken as $key => $value) {
  $token[$key]=$value;
}

$curl = curl_init();

 curl_setopt_array($curl, array(
  CURLOPT_URL => 'https://admin.googleapis.com/admin/directory/v1/users?access_token='.$token['access_token'],
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'POST',
  CURLOPT_POSTFIELDS =>'{
   "name": {
    "familyName": "'.$newset['familyName'].'",
    "givenName": "'.$newset['givenName'].'"
   },
   "password": "'.$newset['password'].'",
   "primaryEmail": "'.$newset['primaryEmail'].'"
   }',
  CURLOPT_HTTPHEADER => array(
   'Content-Type: application/json'
  ),
 ));

 $response = curl_exec($curl);

 curl_close($curl);
 echo $response;
?>
