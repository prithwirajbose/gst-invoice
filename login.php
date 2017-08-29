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
                <tr><td>Username</td><td><input type="text" name="username" id="username" /></td></tr>
                <tr><td>Password</td><td><input type="password" name="password" id="password" /></td></tr>
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
       
        $.ajax({
                    url: "ajax.php",
                    data:$('form[name=loginform]').serialize(),
                    method:'post',
                    success: function(resp) {
                        if(resp && resp.success && resp.success===true && resp.data.redir) {
                            window.location = resp.data.redir;
                        }  else {
                            APP.showError("Login failed." +
                                (resp.message && resp.message ? '<br>' + resp.message : ''));
                        }
                        
                    },
                    error: function(xhr) {
                        APP.showError("Login failed. An error has occured."
                            + (xhr.responseJSON && xhr.responseJSON.message ? '<br>' + xhr.responseJSON.message : ''));
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