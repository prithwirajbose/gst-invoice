<!DOCTYPE html>
<html lang="en">
    <head>
        <title></title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
        <link href="style.css" rel="stylesheet">
    </head>
    <body>
    <div class="container">
        <h1 class="centerheading">Login</h1>
        <div class="loginbox">
            <form name="loginform" method="post" action="login.php">
            <table border="0" cellpadding="5" cellspacing="0">
                <tr><td>Username</td><td><input type="text" name="username" id="username" /></td></tr>
                <tr><td>Password</td><td><input type="password" name="password" id="password" /></td></tr>
                <tr><td>&nbsp;</td><td style="text-align:right"><input type="submit" name="loginsubmit" id="loginsubmit" /></td></tr>
            </table>
            </form>
        </div>
    </div>
    </body>
</html>