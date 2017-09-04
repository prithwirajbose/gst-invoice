
<?php require_once("config.php"); ?>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<script type="text/javascript">
var APP = {};
APP.grids = {};
APP.validationFn = {};
APP.site="<?php echo $config['site']; ?>";
APP.currency="<?php echo !empty($_SESSION['currency']) ? $_SESSION['currency'] : 'INR'; ?>";
</script>
<script src="<?php echo $config['site']; ?>/scripts/jquery-3.2.1.min.js" type="text/javascript"></script>
<script src="<?php echo $config['site']; ?>/scripts/jquery.loader/jquery.loader.js" type="text/javascript"></script>
<script src="<?php echo $config['site']; ?>/scripts/jquery.ui/jquery-ui.min.js" type="text/javascript"></script>
<script src="<?php echo $config['site']; ?>/scripts/jquery.datatables/js/jquery.dataTables.min.js" type="text/javascript"></script>
<script src="<?php echo $config['site']; ?>/scripts/jquery.datatables/js/dataTables.jqueryui.min.js" type="text/javascript"></script>
<script src="<?php echo $config['site']; ?>/scripts/editor/simplemde.min.js"></script>
<script src="<?php echo $config['site']; ?>/scripts/lodash.js"></script>
<script type="text/javascript" src="<?php echo $config['site']; ?>/scripts/common.js"></script>

<link href="font-style.css" rel="stylesheet">
<link rel="stylesheet" href="<?php echo $config['site']; ?>/scripts/jquery.loader/jquery.loader.css">
<link rel="stylesheet" href="<?php echo $config['site']; ?>/scripts/jquery.ui/jquery-ui.min.css">
<link rel="stylesheet" href="<?php echo $config['site']; ?>/scripts/jquery.ui/jquery-ui.theme.min.css">
<link rel="stylesheet" href="<?php echo $config['site']; ?>/scripts/jquery.datatables/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="<?php echo $config['site']; ?>/scripts/jquery.datatables/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="<?php echo $config['site']; ?>/scripts/jquery.datatables/css/dataTables.jqueryui.min.css">
<link rel="stylesheet" href="<?php echo $config['site']; ?>/scripts/editor/simplemde.min.css">
<link href="<?php echo $config['site']; ?>/style.css" rel="stylesheet">