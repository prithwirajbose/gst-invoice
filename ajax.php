<?php
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
    sleep(3);
    return array("status"=>200,"data"=>array("redir"=>$_REQUEST['redir'] ? $_REQUEST['redir'] : 'index.php'));
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