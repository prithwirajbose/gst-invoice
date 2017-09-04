function renderProductListGrid(el) {
    if ($(el).length > 0) {
        var productTable = $(el).DataTable({
            "processing": true,
            "serverSide": true,
            "scrollY": "300px",
            "scrollCollapse": true,
            "aaSorting": [
                [1, 'desc']
            ],
            "ajax": APP.site + "/ajax.php?action=productList",
            "aoColumns": [{
                    "sTitle": '<input type="checkbox" class="gridCheckAll_product gridCheck" style="margin-left:-5px;" ' +
                        'onchange=\'javascript:$(".gridCheck_product").prop("checked",$(this).prop("checked"));\' />',
                    "sWidth": "8%",
                    "mDataProp": "prod_id",
                    "sType": "string",
                    "orderable": false,
                    "searchable": false,
                    "render": function(data, type, row) {
                        return '<input type="checkbox" class="gridCheck_product gridCheck" id="selectProduct_' + data + '" value="' + data + '" />';
                    }
                }, {
                    "sTitle": "ID",
                    "sWidth": "8%",
                    "mDataProp": "prod_id",
                    "sType": "string"
                }, {
                    "sTitle": "Name",
                    "sWidth": "26%",
                    "mDataProp": "prod_name",
                    "sType": "string"
                }, {
                    "sTitle": "Price",
                    "sWidth": "20%",
                    "mDataProp": "unit_price",
                    "sType": "string",
                    "render": function(data, type, row) {
                        return APP.currency + ' ' + data + ' per ' + row.unit_name;
                    }
                }, {
                    "sTitle": "Stock",
                    "sWidth": "25%",
                    "mDataProp": "stock_qty",
                    "sType": "string",
                    "render": function(data, type, row) {
                        return data && data != null && parseInt(data, 10) > 0 ?
                            'In-Stock (' + data + ' ' + row.unit_name + ')' : '<span style="color:red">Out of Stock</span>';
                    }
                },
                {
                    "sTitle": "Tax",
                    "sWidth": "10%",
                    "mDataProp": "tax_rate",
                    "sType": "string",
                    "render": function(data, type, row) {
                        return data + '%';
                    }
                },
                {
                    "sTitle": "Unit Name",
                    "visible": false,
                    "mDataProp": "unit_name",
                    "sType": "string"
                }
            ],
            "initComplete": function(table, resp) {
                $(table.nTableWrapper).find('.dataTables_length').append('<span style="margin-left:20px;">' +
                    '<button type="button" id="gridBtn_addProduct" class="smallbtn">' +
                    '<i class="material-icons">note_add</i> Add</button>' +
                    '<button type="button" id="gridBtn_deleteProduct" class="smallbtn">' +
                    '<i class="material-icons">delete_forever</i> Delete</button></span>');
            }
        });

        APP.grids.productTable = productTable;

        $(el).delegate('tr', 'click', function(e) {

            var data = productTable.row(this).data();
            APP.openUrlInPopup('/partialpages/addUpdateProduct.php?id=' +
                data.prod_id, 'Edit Product', { height: 450, width: 800 });
        });

        $('.productGridContainer').delegate('#gridBtn_addProduct', 'click', function(e) {
            APP.openUrlInPopup('/partialpages/addUpdateProduct.php', 'Add Product', { height: 450, width: 700 });
        });

        $('.productGridContainer').delegate('#gridBtn_deleteProduct', 'click', function(e) {
            if ($('.gridCheck_product:checked').length > 0) {

                APP.confirm("Do you really want to delete selected products(s)?", function() {
                    var selectedIds = [];
                    $('.gridCheck_product:checked').each(function(indx, el) {
                        selectedIds.push($(this).val());
                    });
                    $.ajax({
                        url: APP.site + '/ajax.php?action=deleteProduct',
                        data: 'products=' + selectedIds,
                        method: 'post',
                        success: function(resp) {
                            if (resp.success && resp.success === true) {
                                APP.grids.productTable.ajax.reload();
                            } else {
                                APP.showError("An error has occured." +
                                    (resp.message && resp.message != '' ? '<br>' + resp.message : ''));
                            }
                        }
                    });
                });
            } else {
                APP.showError("Please select atleast one product!");
            }
        });

        $(el).delegate('.gridCheck_product', 'click', function(e) {
            e.stopPropagation();
        });
    }
}