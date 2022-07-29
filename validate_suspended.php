<?php if(isset($_POST['token'])){ $token = $_POST['token']; }else{  $token=json_encode(array()); }?>
<?php if(isset($_POST['email'])){ $email = $_POST['email']; }else{  $email=""; }?>
<?php if(isset($_POST['dataset'])){ $dataset = $_POST['dataset']; }else{
  $dataset=json_encode(array());
}?>
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
    // 'Content-Type: application/json',
    'Accept: application/json',
  );

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

  $setstr = '';

  foreach ($newset as $key => $value) {
    // echo gettype($value);
    switch (gettype($value)) {
      case 'string':
        $setstr .= ' "'.$key.'":'.$value.', ';
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


  // $ch = curl_init();
  //
  // curl_setopt($ch, CURLOPT_URL, );
  // curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
  // curl_setopt($ch, CURLOPT_POSTFIELDS, $setstr);
  // curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
  // curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
  // $error_response = curl_exec($ch);
  // curl_close ($ch);

  $curl = curl_init();
  curl_setopt_array($curl, array(
   CURLOPT_URL => 'https://admin.googleapis.com/admin/directory/v1/users/'.$email,
   CURLOPT_RETURNTRANSFER => true,
   CURLOPT_ENCODING => '',
   CURLOPT_MAXREDIRS => 10,
   CURLOPT_TIMEOUT => 0,
   CURLOPT_FOLLOWLOCATION => true,
   CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
   CURLOPT_CUSTOMREQUEST => 'PUT',
   CURLOPT_POSTFIELDS =>http_build_query($setstr),
   CURLOPT_HTTPHEADER => $headers,
  ));

  $error_response = curl_exec($curl);

  curl_close($curl);

  // echo $error_response;
  // $dataquery = "";
  // if(empty($email)==false){
  //   $dataquery = "&query=email:".$email;
  // }
  //
  // $ch = curl_init();
  //
  // curl_setopt($ch, CURLOPT_URL, 'https://admin.googleapis.com/admin/directory/v1/users?domain=dru.ac.th&maxResults='.$maxresult.$dataquery);
  // curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
  // curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
  //
  //
  // $error_response = curl_exec($ch);
  // curl_close ($ch);
  //
  // // var_dump($error_response);
  $array = json_decode($error_response);
  // // echo "<br/>";
  // // var_dump($array);
  // //
  // // echo json_encode($status);
  if(isset($array->suspended)){
    foreach ($array as $key => $value) {
      $status['data'][$key]=$value;
    }
    if($array->suspended==true){
      $status['status']=true;

    }
    // foreach ($array->users as $key => $value) {
    //   $status['data'][$key]['givenName']=$value->name->givenName;
    //   $status['data'][$key]['familyName']=$value->name->familyName;
    //   $status['data'][$key]['fullName']=$value->name->fullName;
    //   $status['data'][$key]['lastLoginTime']=$value->lastLoginTime;
    //   $status['data'][$key]['creationTime']=$value->creationTime;
    //   $status['data'][$key]['suspended']=$value->suspended;
    //   $status['data'][$key]['primaryEmail']=$value->primaryEmail;
    // }
  }
  if(isset($array->error)){
    foreach ($array as $key => $value) {
      $status['error'][$key]=$value;
    }
  }
}

echo json_encode($status);
?>
