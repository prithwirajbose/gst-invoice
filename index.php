<?php
if(!isset($_SESSION)) {
    session_start();
}
include_once('includes/membervalidation.php');
include_once('config.php');
$isAdmin = $_SESSION['user']['access_level']<=1;
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title>GST Invoice</title>
        <?php include('includes/head.php'); ?>
        <script type="text/javascript" src="<?php echo $config['site']; ?>/scripts/user.js"></script>
        <script type="text/javascript" src="<?php echo $config['site']; ?>/scripts/product.js"></script>
    </head>
    <body>
    <div class="container">
        <div class="main">
            <?php include('includes/pageheading.php'); ?>
            <div class="content">
            <?php if($isAdmin) { ?>
                <div class="twocol widgetbox userGridContainer">
                    <h1 class="sectionheading">Users</h1>
                    <table id="userGrid" class="display datagrid" cellspacing="0" style="width:100%">
                    </table>
                </div>
            <?php } ?>
                <div class="<?php echo $isAdmin ? 'twocol' : 'onecol'; ?> widgetbox productGridContainer">
                    <h1 class="sectionheading">Products</h1>
                    <table id="productGrid" class="display datagrid" cellspacing="0" style="width:100%">
                    </table>
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
        if($('#userGrid').length>0) {
            renderUserListGrid($('#userGrid'));
        }
        if($('#productGrid').length>0) {
            renderProductListGrid($('#productGrid'));
        }
    });
    </script>
    <?php include('includes/uielements.php'); ?>
    </body>
</html>