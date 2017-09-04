<?php 
if(!isset($_SESSION))
    session_start();
include_once("../config.php");
$GLOBALS["__LEVEL"]= 1;
include_once("../includes/membervalidation.php");
$user = array();
if(isset($_REQUEST['id']) && !empty($_REQUEST['id'])) {
$conn = connect();
$id = mysqli_real_escape_string($conn,$_REQUEST['id']);
    $data = mysqli_query($conn,"select * from user where user_id=".$id." and access_level>0 limit 1");
    if(mysqli_num_rows($data)<=0) {
        die("Product doesn't exist or you are not authorized to view this product details");
    }
    while($row = mysqli_fetch_assoc($data)) {
        $user = $row;
    }
disconnect($conn);
}
?>
<div><form name="addUpdateProductForm" method="post" action="<?php echo $config['site']; ?>">
<div class="onecol"><table border="0" cellpadding="5" cellspacing="0" class="fullwidth">
<tr><td>Name<span class="requiredStar">*</span></td><td colspan="4"><input type="text" name="prod_name" id="prod_name" class="fullwidth required" 
    value="<?php echo !empty($user['prod_name']) ? $user['prod_name'] : ''; ?>" label="Product Name"></td></tr>
<tr><td>Description<span class="requiredStar">*</span></td><td colspan="4"><textarea name="prod_details" id="prod_details" class="fullwidth" 
    value="<?php echo !empty($user['prod_details']) ? $user['prod_details'] : ''; ?>" label="Description" 
    style="resize:none; height:80px;"></textarea></td></tr>
<tr><td width="15%">Unit Name<span class="requiredStar">*</span></td><td width="32%">
    <input type="text" name="unit_name" id="unit_name" class="fullwidth required" 
    value="<?php echo !empty($user['unit_name']) ? $user['unit_name'] : ''; ?>" label="Product Unit Name">
    <input type="hidden" name="unit_id" id="unit_id" class="fullwidth" 
    value="<?php echo !empty($user['unit_id']) ? $user['unit_id'] : ''; ?>" label="Product Name">
   </td>
<td width="2%">&nbsp;</td>
<td width="15%">Unit Price<span class="requiredStar">*</span></td><td width="32%"><input type="text" name="unit_price" id="unit_price" class="fullwidth required" 
    value="<?php echo !empty($user['unit_price']) ? $user['unit_price'] : ''; ?>" label="Unit Price of Product"></td></tr>
<tr><td>Tax Category</td><td colspan="4"><input type="text" name="tax_category" id="tax_category" class="fullwidth" 
    value="<?php echo !empty($user['tax_category']) ? $user['tax_category'] : ''; ?>" label="Tax Category"></td></tr>
<tr><td>Tax Rate</td><td><input type="text" name="tax_rate" id="tax_rate" class="fullwidth required" 
    value="<?php echo !empty($user['tax_rate']) ? $user['tax_rate'] : ''; ?>" label="Password"></td>
<td width="2%">&nbsp;</td>
<td>Stock Quantity</td><td><input type="text" name="stock_quantity" id="stock_quantity" class="fullwidth" 
    value="<?php echo !empty($user['stock_quantity']) ? $user['stock_quantity'] : ''; ?>" label="Stock Quantity"></td></tr>
<tr><td>UPC</td><td><input type="text" name="upc" id="upc" class="fullwidth" 
    value="<?php echo !empty($user['upc']) ? $user['upc'] : ''; ?>" label="UPC"></td>
<td width="2%">&nbsp;</td>
<td>SKU</td><td><input type="text" name="sku" id="sku" class="fullwidth" 
    value="<?php echo !empty($user['sku']) ? $user['sku'] : ''; ?>" label="SKU"></td></tr>
<tr><td>MPN</td><td><input type="text" name="mpn" id="mpn" class="fullwidth" 
    value="<?php echo !empty($user['mpn']) ? $user['mpn'] : ''; ?>" label="MPN"></td>
<td width="2%">&nbsp;</td>
<td>Barcode</td><td><input type="text" name="barcode" id="barcode" class="fullwidth" 
    value="<?php echo !empty($user['barcode']) ? $user['barcode'] : ''; ?>" label="Barcode"></td></tr>
<tr><td>Active</td><td><input type="checkbox" name="active_in" id="active_in" value="1"<?php echo isset($user['active_in']) && $user['active_in']=='1' ? ' checked="true"' : ''; ?>></td>
<td width="2%">&nbsp;</td>
<td colspan="2" style="text-align:right">
    <input type="hidden" name="user_id" id="user_id" value="<?php echo !empty($user['user_id']) ? $user['user_id'] : ''; ?>">
    <input type="button" value="Save" onclick="javascript:addUpdateUser(window.event);" /></td>
</table>
</div>

<div class="clear"></div>
</form></div>
<script type="text/javascript">
var unitdata = [];

$(document).ready(function() {
    var simplemde = new SimpleMDE({ element: $("#prod_details")[0] });
    /* $("#unit_name").change(function(e) {
        $('#create_unit').show();
        $('#create_unit').position({my: 'right top', at: 'right top', of: $('#unit_name')});
    }); */
    $("#unit_name").autocomplete({
        position: { my : "left top", at: "lefts bottom" },
        select: function (event, ui) {
            $("#unit_id").val(ui.item.id);
        },
        source: function(req,outFn) {
            $.ajax({
                url: APP.site + '/ajax.php?action=unitSearch',
                data: 'term='+req.term,
                method: 'get',
                success: function(resp) {
                    outFn(resp.data);
                }
            });
        }
    });
});
</script>