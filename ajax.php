<?php
function showResponse($obj) {
    if(!empty($obj['status'])) {
        header("Content-type: application/json");
        header("HTTP/1.1 ".$obj['status']);
        $resp = array("message"=> $obj['message'], "data"=> $obj['data'], "success"=> ($obj['status']==200));
        print json_encode($resp);
    }
}
if(isset($_REQUEST['action']) && !empty($_REQUEST['action'])) {
    $fnName = "fn".$_REQUEST['action'];
    if(function_exists(fnName)) {
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