<?php if(isset($_POST['credentials'])){ $credentials = $_POST['credentials']; }else{
  $credentials=json_encode(array(
    'web'=>array(),
  ));
}?>
<?php if(isset($_POST['token'])){ $token = $_POST['token']; }else{
  $token=json_encode(array()); 
}?>
<?php if(isset($_POST['dataset'])){ $dataset = $_POST['dataset']; }else{  $dataset=""; }?>
<?php
  header('Access-Control-Allow-Origin: *');
  ini_set('error_reporting', E_ALL);
  ini_set('display_errors', 1);
  require __DIR__ . '/vendor/autoload.php';


  $client = new Google_Client();


  $datacredentials = json_decode($credentials);
  // var_dump($credentials);
  $credentials = array();
  foreach ($datacredentials->web as $key => $value) {
    // array_push($credentials,array($key=>$value));
    $credentials[$key]=$value;
  }

  $client->setAuthConfig($credentials);

  $client->setSubject('tossapol.c@dru.ac.th');

  $client->addScope('https://www.googleapis.com/auth/admin.directory.user');


  $datatoken = json_decode($token);
  // var_dump($datatoken);
  $token = array();
  foreach ($datatoken as $key => $value) {
    $token[$key]=$value;
  }

  $client->setAccessToken($token['access_token']);


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
