<?php
include_once('config.php');
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
    if(empty($_REQUEST['username']) || empty($_REQUEST['password'])) {
        return array("status"=>400, "message"=>"Username and Password is required");
    }
    $data = mysqli_query($conn,"select * from user where username='".mysqli_real_escape_string($conn, $_REQUEST['username'])."' 
        and password='".mysqli_real_escape_string($conn,$_REQUEST['password'])."' and active_in=1 limit 1") or die(mysqli_error($conn));
    if(mysqli_num_rows($data)==1) {
        while($row = mysqli_fetch_assoc($data)) {
            $_SESSION['user']=$row;
        }
        $_SESSION['currency']='INR';
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

function fn_addProduct() {
    die();
    $authStatus = authCheck(1);
    if($authStatus!==true) {
        return $authStatus;
    }
    if(empty($_REQUEST['username']) || empty($_REQUEST['password']) || empty($_REQUEST['email_id'])
     || empty($_REQUEST['full_name']) || empty($_REQUEST['access_level'])) {
        return array("status"=>400, "message"=>"Required fields are missing");
    }
    $conn = connect();
    $username = mysqli_real_escape_string($conn, $_REQUEST['username']);
    $password = mysqli_real_escape_string($conn, $_REQUEST['password']);
    $email_id = mysqli_real_escape_string($conn, $_REQUEST['email_id']);
    $full_name = mysqli_real_escape_string($conn, $_REQUEST['full_name']);
    $active_in = mysqli_real_escape_string($conn, isset($_REQUEST['active_in']) ? $_REQUEST['active_in'] : 0);
    $access_level = mysqli_real_escape_string($conn, isset($_REQUEST['access_level']) ? $_REQUEST['access_level'] : 2);
    
    $udata = mysqli_query($conn,"select * from user where username = '" . $username ."' limit 1");
    if(mysqli_num_rows($udata)>0) {
        return array("status"=>400, "message"=>"Username already exists! Please use a unique one.");
    }

    $qry = "insert into user (username,password,email_id,full_name,active_in,access_level) values('"
    .$username."','".$password."', '".$email_id."','".$full_name."','".$active_in."','"
    .$access_level."')";
    $res = mysqli_query($conn, $qry) or trigger_error(mysqli_error($conn));
    disconnect($conn);
        
    return array("status"=>200,"message"=>"successfully updated");
}

function fn_updateProduct() {
    $authStatus = authCheck(1);
    if($authStatus!==true) {
        return $authStatus;
    }
    if(empty($_REQUEST['prod_id']) || empty($_REQUEST['username']) || empty($_REQUEST['password']) || empty($_REQUEST['email_id'])
     || empty($_REQUEST['full_name']) || empty($_REQUEST['access_level'])) {
        return array("status"=>400, "message"=>"Required fields are missing");
    }
    $conn = connect();
    $user_id = mysqli_real_escape_string($conn, $_REQUEST['user_id']);
    $username = mysqli_real_escape_string($conn, $_REQUEST['username']);
    $password = mysqli_real_escape_string($conn, $_REQUEST['password']);
    $email_id = mysqli_real_escape_string($conn, $_REQUEST['email_id']);
    $full_name = mysqli_real_escape_string($conn, $_REQUEST['full_name']);
    $active_in = mysqli_real_escape_string($conn, isset($_REQUEST['active_in']) ? $_REQUEST['active_in'] : 0);
    $access_level = mysqli_real_escape_string($conn, isset($_REQUEST['access_level']) ? $_REQUEST['access_level'] : 2);
    $qry = "update user set username='".$username."', password='".$password."', email_id='".$email_id."',"
        . "full_name='".$full_name."' ";
    if($user_id!=$_SESSION['user']['user_id']) {
        $qry .= ", active_in=".$active_in.", access_level=".$access_level." ";
    }
    $qry .= " where user_id=".$user_id;
    mysqli_query($conn, $qry) or die(mysqli_error($conn));
    disconnect($conn);
    return array("status"=>200,"message"=>"successfully updated");
}

function fn_deleteProduct() {
    die();
    $authStatus = authCheck(1);
    if($authStatus!==true) {
        return $authStatus;
    }

    if(!isset($_REQUEST['users']) || empty($_REQUEST['users'])) {
         return array("status"=>400, "message"=>"Required fields are missing");
    }
    
    $conn = connect();
    $users = $_REQUEST['users'];
    if(strpos($users,",")!==false) {
        $userArr = explode(",",$users);
        for($y=0; $y<sizeof($userArr); $y++) {
            $userArr[$y] = mysqli_real_escape_string($conn,$userArr[$y]);
        }
        $users = implode(",",$userArr);
    }
    else {
        $users = mysqli_real_escape_string($conn,$users);
    }
    mysqli_query($conn, "delete from user where user_id in (".$users.")") or die(mysqli_error($conn));
    disconnect($conn);
    return array("status"=>200,"message"=>"Records deleted");
}

function fn_addUser() {
    $authStatus = authCheck(1);
    if($authStatus!==true) {
        return $authStatus;
    }
    if(empty($_REQUEST['username']) || empty($_REQUEST['password']) || empty($_REQUEST['email_id'])
     || empty($_REQUEST['full_name']) || empty($_REQUEST['access_level'])) {
        return array("status"=>400, "message"=>"Required fields are missing");
    }
    $conn = connect();
    $username = mysqli_real_escape_string($conn, $_REQUEST['username']);
    $password = mysqli_real_escape_string($conn, $_REQUEST['password']);
    $email_id = mysqli_real_escape_string($conn, $_REQUEST['email_id']);
    $full_name = mysqli_real_escape_string($conn, $_REQUEST['full_name']);
    $active_in = mysqli_real_escape_string($conn, isset($_REQUEST['active_in']) ? $_REQUEST['active_in'] : 0);
    $access_level = mysqli_real_escape_string($conn, isset($_REQUEST['access_level']) ? $_REQUEST['access_level'] : 2);
    
    $udata = mysqli_query($conn,"select * from user where username = '" . $username ."' limit 1");
    if(mysqli_num_rows($udata)>0) {
        return array("status"=>400, "message"=>"Username already exists! Please use a unique one.");
    }

    $qry = "insert into user (username,password,email_id,full_name,active_in,access_level) values('"
    .$username."','".$password."', '".$email_id."','".$full_name."','".$active_in."','"
    .$access_level."')";
    $res = mysqli_query($conn, $qry) or trigger_error(mysqli_error($conn));
    disconnect($conn);
        
    return array("status"=>200,"message"=>"successfully updated");
}

function fn_updateUser() {
    $authStatus = authCheck(1);
    if($authStatus!==true) {
        return $authStatus;
    }
    if(empty($_REQUEST['user_id']) || empty($_REQUEST['username']) || empty($_REQUEST['password']) || empty($_REQUEST['email_id'])
     || empty($_REQUEST['full_name']) || empty($_REQUEST['access_level'])) {
        return array("status"=>400, "message"=>"Required fields are missing");
    }
    $conn = connect();
    $user_id = mysqli_real_escape_string($conn, $_REQUEST['user_id']);
    $username = mysqli_real_escape_string($conn, $_REQUEST['username']);
    $password = mysqli_real_escape_string($conn, $_REQUEST['password']);
    $email_id = mysqli_real_escape_string($conn, $_REQUEST['email_id']);
    $full_name = mysqli_real_escape_string($conn, $_REQUEST['full_name']);
    $active_in = mysqli_real_escape_string($conn, isset($_REQUEST['active_in']) ? $_REQUEST['active_in'] : 0);
    $access_level = mysqli_real_escape_string($conn, isset($_REQUEST['access_level']) ? $_REQUEST['access_level'] : 2);
    $qry = "update user set username='".$username."', password='".$password."', email_id='".$email_id."',"
        . "full_name='".$full_name."' ";
    if($user_id!=$_SESSION['user']['user_id']) {
        $qry .= ", active_in=".$active_in.", access_level=".$access_level." ";
    }
    $qry .= " where user_id=".$user_id;
    mysqli_query($conn, $qry) or die(mysqli_error($conn));
    disconnect($conn);
    return array("status"=>200,"message"=>"successfully updated");
}

function fn_deleteUser() {
    $authStatus = authCheck(1);
    if($authStatus!==true) {
        return $authStatus;
    }

    if(!isset($_REQUEST['users']) || empty($_REQUEST['users'])) {
         return array("status"=>400, "message"=>"Required fields are missing");
    }
    
    $conn = connect();
    $users = $_REQUEST['users'];
    if(strpos($users,",")!==false) {
        $userArr = explode(",",$users);
        for($y=0; $y<sizeof($userArr); $y++) {
            $userArr[$y] = mysqli_real_escape_string($conn,$userArr[$y]);
        }
        $users = implode(",",$userArr);
    }
    else {
        $users = mysqli_real_escape_string($conn,$users);
    }
    mysqli_query($conn, "delete from user where user_id in (".$users.")") or die(mysqli_error($conn));
    disconnect($conn);
    return array("status"=>200,"message"=>"Records deleted");
}

function fn_unitSearch() {
    if(!isset($_REQUEST['term']) || empty($_REQUEST['term'])) {
        return array("status"=>400,"message"=>"Search term is missing");
    }
    $authStatus = authCheck(2);
    if($authStatus!==true) {
        return $authStatus;
    }
    $conn = connect();
    $term = strtolower(mysqli_real_escape_string($conn, $_REQUEST['term']));
    $data = mysqli_query($conn,"select unit_name as value, unit_name as label, unit_id as id ".
        " from product_unit where lower(unit_name) like '".$term."%' order by unit_name asc");
    $res = array();
    if(mysqli_num_rows($data)>0) {
        while($row = mysqli_fetch_assoc($data)) {
            array_push($res,$row);
        }
    }
    return array("status"=>200, "data"=>$res);
    disconnect($conn);
}

function fn_createUnit() {
    if(!isset($_REQUEST['unit_name']) || empty($_REQUEST['unit_name'])) {
        return array("status"=>400,"message"=>"Unit Name is missing");
    }
    $authStatus = authCheck(2);
    if($authStatus!==true) {
        return $authStatus;
    }
    $conn = connect();
    $unit_name = mysqli_real_escape_string($conn, $_REQUEST['unit_name']);
    $fraction_allowed = mysqli_real_escape_string($conn, isset($_REQUEST['fraction_allowed']) ? $_REQUEST['fraction_allowed'] : 1);
    $data = mysqli_query($conn,"select unit_id as id ".
        " from product_unit where lower(unit_name) = '".strtolower($unit_name)."' limit 1");
    $id = 0;
    if(mysqli_num_rows($data)>0) {
        while($row = mysqli_fetch_assoc($data)) {
            $id = $row['id'];
        }
    }
    else {
        mysqli_query($conn,"insert into product_unit (unit_name, fraction_allowed_in) values ('" .
            $unit_name . "', '" . $fraction_allowed ."')");
        $id = mysqli_insert_id($conn);
    }
    return array("status"=>200, "data"=>array("unit_id"=>$id));
    disconnect($conn);
}

function fn_productList() {
    $authStatus = authCheck(2);
    if($authStatus!==true) {
        return $authStatus;
    }
    $conn = connect();

    $cols = array("prod_id", "prod_id","prod_name","unit_price","stock_qty","tax_rate","unit_name");
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
        $whereclause = " where (p.prod_name like '%" . mysqli_real_escape_string($conn, $_REQUEST['search']['value']) ."%' or ";
        $whereclause .= "p.prod_id like '" . mysqli_real_escape_string($conn, $_REQUEST["search"]["value"]) ."%' or ";
        $whereclause .= "p.upc like '" . mysqli_real_escape_string($conn, $_REQUEST["search"]["value"]) ."%' or ";
        $whereclause .= "p.mpn like '" . mysqli_real_escape_string($conn, $_REQUEST["search"]["value"]) ."%' or ";
        $whereclause .= "p.barcode like '" . mysqli_real_escape_string($conn, $_REQUEST["search"]["value"]) ."%' or ";
        $whereclause .= "p.hsn_code like '" . mysqli_real_escape_string($conn, $_REQUEST["search"]["value"]) ."%') ";
    }    
    $data = [];
    $totalcount=0;
    $filtercount=0;

 
    $dataset = mysqli_query($conn,"select prod_id as prod_id, prod_name as prod_name, unit_price as unit_price, "
        . "stock_qty as stock_qty, unit_name as unit_name, "
        . " case hsn_code when '' then tax_rate when null then tax_rate else gst_rate end as tax_rate "
        . "from (select p.*, pu.unit_name, h.gst_rate from product_unit pu, product p left outer join hsn h on "
        . "h.hsn_code=p.hsn_code " . (!empty($whereclause) ? $whereclause . ' and ' : ' where ')
        . " p.unit_id=pu.unit_id) as T ".$orderclause." limit "
        . mysqli_real_escape_string($conn,$_REQUEST['start']).","
        . mysqli_real_escape_string($conn,$_REQUEST['length'])
        ) or die(mysqli_error($conn));
    
    $countdata = mysqli_query($conn,"select count(*) from product") or die(mysqli_error($conn));
    $filtercountdata = mysqli_query($conn, "select count(*) from product p ".$whereclause) or die(mysqli_error($conn));
    while($countrow=mysqli_fetch_array($countdata)) {
        $totalcount = $countrow[0];
    }
    while($filtercountrow=mysqli_fetch_array($filtercountdata)) {
        $filtercount = $filtercountrow[0];
    }
    
    if(mysqli_num_rows($dataset)>0) {
        while($row = mysqli_fetch_assoc($dataset)) {
            array_push($data,$row);
        }
    }
    disconnect($conn);
    return array("status"=>200, "draw"=>$_REQUEST['draw'], "recordsTotal"=>$totalcount, "recordsFiltered"=>$filtercount, 
        "data"=> $data);
}

function fn_userList() {
    $authStatus = authCheck(1);
    if($authStatus!==true) {
        return $authStatus;
    }
    $conn = connect();

    $cols = array("user_id", "full_name","email_id","username","active_in","access_level");
    $orderclause = ' order by ';
    $comma = '';
    for($i=0;$i<sizeof($cols);$i++) {
        if(!empty($_REQUEST['order'][$i])) {
            $orderclause = $orderclause. $comma . $cols[$_REQUEST['order'][$i]['column']] 
                . ' ' . mysqli_real_escape_string($conn, $_REQUEST['order'][$i]['dir']);
            $comma = ',';
        }
    }

    $whereclause = ' where access_level>0 ';
    if(!empty($_REQUEST['search']['value'])) {
        $whereclause .= " and (full_name like '%" . mysqli_real_escape_string($conn, $_REQUEST['search']['value']) ."%' or ";
        $whereclause .= "email_id like '" . mysqli_real_escape_string($conn, $_REQUEST["search"]["value"]) ."%' or ";
        $whereclause .= "username like '" . mysqli_real_escape_string($conn, $_REQUEST["search"]["value"]) ."%') ";
    }    
    $data = [];
    $totalcount=0;
    $filtercount=0;
   $dataset = mysqli_query($conn,"select * from user " .$whereclause. " ".$orderclause." limit "
        . mysqli_real_escape_string($conn,$_REQUEST['start']).","
        . mysqli_real_escape_string($conn,$_REQUEST['length'])
        ) or die(mysqli_error($conn));
    $countdata = mysqli_query($conn,"select count(*) from user where access_level>0") or die(mysqli_error($conn));
    $filtercountdata = mysqli_query($conn, "select count(*) from user ".$whereclause) or die(mysqli_error($conn));
    while($countrow=mysqli_fetch_array($countdata)) {
        $totalcount = $countrow[0];
    }
    while($filtercountrow=mysqli_fetch_array($filtercountdata)) {
        $filtercount = $filtercountrow[0];
    }
    
    if(mysqli_num_rows($dataset)>0) {
        while($row = mysqli_fetch_assoc($dataset)) {
            array_push($data,$row);
        }
    }
    disconnect($conn);
    return array("status"=>200, "draw"=>$_REQUEST['draw'], "recordsTotal"=>$totalcount, "recordsFiltered"=>$filtercount, 
        "data"=> $data);
}

if(isset($_REQUEST['action']) && !empty($_REQUEST['action'])) {
    $fnName = "fn_".$_REQUEST['action'];
    if(function_exists($fnName)) {
        showResponse($fnName());
    }
    else {
        showResponse(array("status"=>400,"message"=>"Invalid or unknown request parameters!"));
    }
}
else {
    showResponse(array("status"=>400,"message"=>"Required parameter missing!"));
}
?>