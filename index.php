<!DOCTYPE html>
<html lang="en">
    <head>
        <title>GST Invoice</title>
        <?php include('includes/head.php'); ?>
    </head>
    <body>
    <div class="container">
        <nav class="main">
        <div class="logo"><img src="images/logo.png" /></div>
        <div class="toolbox">Welcome <b>User</b><br /><a href="#" class="logout">Logout</a></div>
        <div class="clear">&nbsp;</div>
        <nav>
        <ul>
        <li><a href="index.php">Home</a></li>
        <li><a href="index2.php">Configuration</a></li>
        <li><a href="index2.php">Profile</a></li>
        </ul>
        </nav>
        </div>
    </div>
    <script type="text/javascript">
    var doLogin = function() {
       
        $.ajax({
                    url: "ajax.php",
                    data:$('form[name=loginform]').serialize(),
                    method:'post',
                    success: function(resp) {
                        APP.showInfo("Success");
                    },
                    error: function(xhr) {
                        APP.showError("Login failed. An error has occured."
                            + (xhr.responseJSON && xhr.responseJSON.message ? '<br>' + xhr.responseJSON.message : ''));
                        console.log(xhr);
                    }
                });
    };
    $(document).ready(function(){
        $('#loginsubmit').click(function(e) {
            doLogin();
        });
        $('#username, #password').keypress(function(e) {
            if(e.which===13) {
                doLogin();
            }
        });
    });
    </script>
    <?php include('includes/uielements.php'); ?>
    </body>
</html>