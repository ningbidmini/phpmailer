<?php if(isset($_POST['clientID'])){ $clientID = $_POST['clientID']; }else{
  $clientID="791468006113-p30n83g10nkl5tjasshvrkdljbed13pa.apps.googleusercontent.com"; }
  ?>
<?php if(isset($_POST['redirecturl'])){ $redirecturl = $_POST['redirecturl']; }else{  $redirecturl="https://e-portfolio.dru.ac.th/views/backend/token.php"; }?>
<?php if(isset($_POST['scope'])){ $scope = $_POST['scope']; }else{
  $scope="email profile https://www.googleapis.com/auth/admin.directory.user "; }
  ?>
<?php
  $url = 'https://accounts.google.com/o/oauth2/auth';
  $dataset = array(
    'response_type'=>'code',
    'access_type'=>'online',
    'client_id'=>$clientID,
    // 'redirect_uri'=>'http://localhost/apigmail/',
    'redirect_uri'=>$redirecturl,
    'state'=>'',
    'scope'=>$scope,
    'approval_prompt'=>'auto',
  );
  $strget='';
  $pointer=0;
  foreach ($dataset as $key => $value) {
    if($pointer==0){
      $strget .= $key.'='.$value;
    }else{
      $strget .= '&'.$key.'='.$value;
    }
    $pointer++;
  }
  $url=$url.'?'.$strget;
  header('location:'.$url);
?>
