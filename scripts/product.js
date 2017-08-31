function renderProductListGrid(el) {
    if ($(el).length > 0) {
        var productTable = $(el).DataTable({
            "processing": true,
            "serverSide": true,
            "scrollY": "300px",
            "scrollCollapse": true,
            "ajax": APP.site + "/ajax.php?action=productList",
            "aoColumns": [{
                    "sTitle": "ID",
                    "sWidth": "8%",
                    "mDataProp": "prod_id",
                    "sType": "string"
                }, {
                    "sTitle": "Name",
                    "sWidth": "34%",
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
            ]
        });
        APP.grids.productTable = productTable;
    }
}