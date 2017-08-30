<?php
if(!isset($_SESSION)) {
    session_start();
}
include_once('includes/membervalidation.php')
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title>GST Invoice</title>
        <?php include('includes/head.php'); ?>
    </head>
    <body>
    <div class="container">
        <div class="main">
            <?php include('includes/pageheading.php'); ?>
            <div class="content">
                <div class="twocol widgetbox">
                    <h1 class="sectionheading">User List</h1>
                    <table id="userGrid" class="display datagrid" cellspacing="0">
                    </table>
                </div>
                <div class="twocol widgetbox">
                    <h1 class="sectionheading">User List</h1>
                    
                </div>
                <div class="onecol widgetbox">
                    <h1 class="sectionheading">User List</h1>
                    
                </div>
                <div class="clear"></div>
            </div>
        </div>
        
            <?php include('includes/footer.php'); ?>
    </div>
    <script type="text/javascript">
    
    $(document).ready(function(){
        var userTable = $('#userGrid').DataTable( {
            "processing": true,
            "serverSide": true,
            "ajax": APP.site + "/ajax.php?action=userList",
            "aoColumns" : [
                {
                "sTitle" : "Name",
                "sWidth" : "25%",
                "mDataProp" : "full_name",
                "sType" : "string"
                }, {
                "sTitle" : "Email ID",
                "sWidth" : "31%",
                "mDataProp" : "email_id",
                "sType" : "string"
                }, {
                "sTitle" : "Username",
                "sWidth" : "20%",
                "mDataProp" : "username",
                "sType" : "string"
                }, { 
                "sTitle" : "Status",
                "sWidth" : "12%",
                "mDataProp" : "active_in",
                "sType" : "string",
                "render": function ( data, type, row ) {
                    return data == 1 ? 'Active' : 'Inactive';
                }
                }, {
                "sTitle" : "Access Level",
                "sWidth" : "12%",
                "mDataProp" : "access_level",
                "sType" : "string",
                "render": function ( data, type, row ) {
                    var accessLevel = {
                        "1" : "Admin",
                        "2" : "End User"
                    }
                    return accessLevel[data];
                }
                } 
            ]
        });
        
        /*$('#userGrid1').DataTable( {
            "processing": true,
            "serverSide": true,
            "ajax": APP.site + "/ajax.php?action=userList"
        });
        $('#userGrid2').DataTable( {
            "processing": true,
            "serverSide": true,
            "ajax": APP.site + "/ajax.php?action=userList"
        });*/
    });
    </script>
    <?php include('includes/uielements.php'); ?>
    </body>
</html>