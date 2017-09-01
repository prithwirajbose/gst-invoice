<!DOCTYPE html>
<html lang="en">
    <head>
        <title>GST Invoice</title>
        <?php include('includes/head.php'); ?>
    </head>
    <body>
    <div class="container">
        <h1 class="centerheading"><img src="images/logo.png" /></h1>
        <div class="loginbox">
        <p style="margin:-10px -10px 10px -10px; padding:3px; background:#666; color:#fff; border-radius:5px 5px 0px 0px;">Login</p>
            <form name="loginform" method="post" action="login.php">
            <table border="0" cellpadding="5" cellspacing="0">
                <tr><td>Username</td><td><input type="text" name="username" id="username" class="required" label="Username" /></td></tr>
                <tr><td>Password</td><td><input type="password" name="password" id="password" class="required" label="Password" /></td></tr>
                <tr><td>&nbsp;</td><td style="text-align:right">
                <input type="hidden" name="redir" 
                value="<?php echo !empty($_REQUEST['redir']) ? urlencode( $_REQUEST['redir'] ) : ""; ?>">
                <input type="hidden" name="action" value="login">
                <input type="button" name="loginsubmit" 
                id="loginsubmit" value="Login" /></td></tr>
            </table>
            </form>
        </div>
    </div>
    <script type="text/javascript">
    var doLogin = function() {
       if(!APP.validateForm($('form[name=loginform]'))) {
           return false;
       }
        $.ajax({
                    url: APP.site + "/ajax.php",
                    data:$('form[name=loginform]').serialize(),
                    method:'post',
                    success: function(resp) {
                        if(resp && resp.success && resp.success===true) {
                            APP.redirecting();
                            if(resp.data && resp.data.redir && resp.data.redir!=null && resp.data.redir!='')
                                window.location = decodeURIComponent(resp.data.redir);
                            else
                                window.location = APP.site + '/index.php';
                        }  else {
                            APP.showError("Login failed." +
                                (resp.message && resp.message ? '<br>' + resp.message : ''));
                        }
                        
                    }
                });
    };
    $(document).ready(function(){
        $('#loginsubmit').click(function(e) {
            doLogin();
        });
        $('#username, #password').keyup(function(e) {
            if(e.which===13) {
                doLogin();
            }
        });
        $('#username').focus();
    });
    </script>
    <?php include('includes/uielements.php'); ?>
    </body>
</html>