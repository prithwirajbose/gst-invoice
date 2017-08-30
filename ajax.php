<?php
require_once('db.php');
if(!isset($_SESSION)) {
    session_start();
}

function getAccessLevelName($level) {
    if($level==1) {
        return 'Admin';
    }
    elseif($level==2) {
        return 'End User';
    }
}

function showResponse($obj) {
    if(!empty($obj['status'])) {
        header("Content-type: application/json");
        header("HTTP/1.1 ".$obj['status']);
        $resp = $obj;
        $resp["success"] = ($obj['status']==200);
        print json_encode($resp);
    }
}

function authCheck($maxAllowedLevel=0) {
    if(isset($_SESSION['user']) && !empty($_SESSION['user']) && !empty($_SESSION['user']['username'])) {
        if($maxAllowedLevel==0 || ($maxAllowedLevel>0 && $_SESSION['user']['access_level']<=$maxAllowedLevel)) {
            return true;
        }
    }
    return array("status"=>403, "message"=>"You are not authorized to perform this action.");
}

function fn_login() {
    $conn = connect();
    $data = mysqli_query($conn,"select * from user where username='".mysqli_real_escape_string($conn, $_REQUEST['username'])."' 
        and password='".mysqli_real_escape_string($conn,$_REQUEST['password'])."' and active_in=1 limit 1") or die(mysql_error());
    if(mysqli_num_rows($data)==1) {
        while($row = mysqli_fetch_assoc($data)) {
            $_SESSION['user']=$row;
        }
        disconnect($conn);
       return array("status"=>200,"data"=>array("redir"=>!empty($_REQUEST['redir']) ? $_REQUEST['redir'] : null));
    }
    else {
        disconnect($conn);
        return array("status"=>403,"message"=>"Incorrect username or password!");
    }
}

function fn_logout() {
    $_SESSION['user']=NULL;
    unset($_SESSION);
    session_unset();
    return array("status"=>200);
}

function fn_userList() {
    $authStatus = authCheck(1);
    if($authStatus!==true) {
        return $authStatus;
    }
    $conn = connect();

    $cols = array("full_name","email_id","username","active_in","access_level");
    $orderclause = ' order by ';
    $comma = '';
    for($i=0;$i<sizeof($cols);$i++) {
        if(!empty($_REQUEST['order'][$i])) {
            $orderclause = $orderclause. $comma . $cols[$_REQUEST['order'][$i]['column']] 
                . ' ' . mysqli_real_escape_string($conn, $_REQUEST['order'][$i]['dir']);
            $comma = ',';
        }
    }

    $whereclause = '';
    if(!empty($_REQUEST['search']['value'])) {
        $whereclause = " where full_name like '%" . mysqli_real_escape_string($conn, $_REQUEST['search']['value']) ."%' or ";
        $whereclause .= "email_id like '" . mysqli_real_escape_string($conn, $_REQUEST["search"]["value"]) ."%' or ";
        $whereclause .= "username like '" . mysqli_real_escape_string($conn, $_REQUEST["search"]["value"]) ."%' ";
    }    
    $data = [];
    $dataset = mysqli_query($conn,"select * from user " .$whereclause. " ".$orderclause." limit "
        . mysqli_real_escape_string($conn,$_REQUEST['start']).","
        . mysqli_real_escape_string($conn,$_REQUEST['length'])
        ) or die(mysql_error());
    $countdata = mysqli_query($conn,"select username from user") or die(mysql_error());
    $totalcount = mysqli_num_rows($countdata);
    if(mysqli_num_rows($dataset)>0) {
        while($row = mysqli_fetch_assoc($dataset)) {
            array_push($data,$row);
        }
    }
    disconnect($conn);
    return array("status"=>200, "draw"=>$_REQUEST['draw'], "recordsTotal"=>$totalcount, "recordsFiltered"=>sizeof($data), 
        "data"=> $data);
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