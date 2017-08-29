<?php
require_once('db.php');
function showResponse($obj) {
    if(!empty($obj['status'])) {
        header("Content-type: application/json");
        header("HTTP/1.1 ".$obj['status']);
        $resp = array("success"=> ($obj['status']==200));
        if(!empty($obj['message'])) {
           $resp["message"]=$obj['message'];
        }
        if(!empty($obj['data'])) {
            $resp['data'] = $obj['data'];
        }
        print json_encode($resp);
    }
}

function fn_login() {
    $conn = connect();
    $data = mysqli_query($conn,"select * from user where username='".mysqli_real_escape_string($conn, $_REQUEST['username'])."' 
        and password='".mysqli_real_escape_string($conn,$_REQUEST['password'])."' and active_in=true limit 1") or die(mysql_error());
    if(mysqli_num_rows($data)==1) {
       return array("status"=>200,"data"=>array("redir"=>$_REQUEST['redir'] ? $_REQUEST['redir'] : 'index.php'));
    }
    else {
        return array("status"=>200,"message"=>"Incorrect username or password!");
    }
}

function fn_logout() {
    sleep(5);
    return array("status"=>200);
}


if(isset($_REQUEST['action']) && !empty($_REQUEST['action'])) {
    $fnName = "fn_".$_REQUEST['action'];
    if(function_exists($fnName)) {
        showResponse($fnName());
    }
    else {
        showResponse(array("status"=>400,"message"=>"Required parameter missing"));
    }
}
else {
    showResponse(array("status"=>400,"message"=>"Required parameter missing"));
}
?>