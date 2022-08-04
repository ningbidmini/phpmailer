<?php if(isset($_POST['token'])){ $token = $_POST['token']; }else{  $token=json_encode(array()); }?>
<?php if(isset($_POST['maxresult'])){ $maxresult = $_POST['maxresult']; }else{  $maxresult="200"; }?>
<?php if(isset($_POST['search'])){ $search = $_POST['search']; }else{  $search=""; }?>
<?php if(isset($_POST['dataset'])){ $dataset = $_POST['dataset']; }else{  $dataset=""; }?>
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
$status['message']='';

if(count($token)>0){
  $apikey='AIzaSyDSr5icH2KrI_YEZKSXQ-iZW973y9u1jLU';

  // $dataset=json_encode(array(
  //   'password'=>'T87654321',
  //   'primaryEmail'=>'tossapol.cc@dru.ac.th',
  //   'recoveryPhone'=>'+66660249451',
  //   'name'=>array(
  //     'familyName'=>'testx',
  //     'givenName'=>'testxxx',
  //   ),
  // ));


  $newset = array();
  $getdata = json_decode($dataset);
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

  $setstr = '';

  foreach ($newset as $key => $value) {
    // echo gettype($value);
    switch (gettype($value)) {
      case 'string':
        $setstr .= ' "'.$key.'":"'.$value.'", ';
      break;
      case 'array':
        $newarray = $value;
        $setstr .= ' "'.$key.'": {';
        foreach ($newarray as $keyone => $valueone) {
          $setstr .= ' "'.$keyone.'":"'.$valueone.'", ';
        }
        $setstr .= ' },';
      break;
    }
  }
  $setstr = '{'.$setstr.'}';

  // echo $setstr;
  $headers = array(
    // 'Authorization: Bearer '.$token['access_token'].'',
    'Content-Type: application/json',
    // 'Accept: application/json',
  );
  $dataquery = "";
  if(empty($search)==false){
    $dataquery = "&query=email:".$search;
  }

  $ch = curl_init();

  curl_setopt($ch, CURLOPT_URL, 'https://admin.googleapis.com/admin/directory/v1/users?access_token='.$token['access_token']);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
  curl_setopt($ch, CURLOPT_ENCODING, 'utf-8');
  curl_setopt($ch, CURLOPT_MAXREDIRS, 10);
  curl_setopt($ch, CURLOPT_TIMEOUT, 0);
  curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
  curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
  curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
  curl_setopt($ch, CURLOPT_POSTFIELDS, $setstr);

  $error_response = curl_exec($ch);
  curl_close ($ch);

  var_dump($error_response);
  $array = json_decode($error_response);
  // echo "<br/>";
  // var_dump($array);
  //
  // echo json_encode($status);
  // if(isset($array->users)){
  //   $status['status']=true;
  //   foreach ($array->users as $key => $value) {
  //     $status['data'][$key]['givenName']=$value->name->givenName;
  //     $status['data'][$key]['familyName']=$value->name->familyName;
  //     $status['data'][$key]['fullName']=$value->name->fullName;
  //     $status['data'][$key]['lastLoginTime']=$value->lastLoginTime;
  //     $status['data'][$key]['creationTime']=$value->creationTime;
  //     $status['data'][$key]['suspended']=$value->suspended;
  //     $status['data'][$key]['primaryEmail']=$value->primaryEmail;
  //   }
  // }

  if(isset($array->error)){
    $status['message']='Duplicate!!!';
  }
}

echo json_encode($status);
?>
