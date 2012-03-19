<?php

    require_once('login.class.php');

    $browserID = new BrowserID($_SERVER['HTTP_HOST'], $_POST['assertion']);

    if($browserID->verify_assertion()) {
 
       echo json_encode(array('status'=>'okay', 'email'=>$browserID->getEmail()));

    } else {

       echo json_encode(array('status'=>'failure','reason'=>$browserID->getReason()));
    }

?>