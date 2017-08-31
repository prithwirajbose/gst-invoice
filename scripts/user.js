function renderUserListGrid(el) {
    if ($(el).length > 0) {
        var userTable = $(el).DataTable({
            "processing": true,
            "serverSide": true,
            "scrollY": "300px",
            "scrollCollapse": true,
            "ajax": APP.site + "/ajax.php?action=userList",
            "aoColumns": [{
                "sTitle": "-",
                "sWidth": "6%",
                "mDataProp": "user_id",
                "sType": "string",
                "sortable": false,
                "searchable": false,
                "render": function(data, type, row) {
                    return '<input type="checkbox" class="gridCheck_user gridCheck" id="selectUser_' + data + '" value="' + data + '" />';
                }
            }, {
                "sTitle": "Name",
                "sWidth": "22%",
                "mDataProp": "full_name",
                "sType": "string"
            }, {
                "sTitle": "Email ID",
                "sWidth": "31%",
                "mDataProp": "email_id",
                "sType": "string"
            }, {
                "sTitle": "Username",
                "sWidth": "15%",
                "mDataProp": "username",
                "sType": "string"
            }, {
                "sTitle": "Status",
                "sWidth": "12%",
                "mDataProp": "active_in",
                "sType": "string",
                "render": function(data, type, row) {
                    return data == 1 ? '<span style="color:green;">Active</span>' : '<span style="color:red;">Inactive</span>';
                }
            }, {
                "sTitle": "Type",
                "sWidth": "12%",
                "mDataProp": "access_level",
                "sType": "string",
                "render": function(data, type, row) {
                    var accessLevel = {
                        "1": "Admin",
                        "2": "End User"
                    }
                    return accessLevel[data];
                }
            }],
            "initComplete": function(table, resp) {
                $(table.nTableWrapper).find('.dataTables_length').append('<span style="margin-left:20px;">' +
                    '<button type="button" id="gridBtn_addUser" class="smallbtn">' +
                    '<i class="material-icons">note_add</i> Add</button>' +
                    '<button type="button" id="gridBtn_deleteUser" class="smallbtn">' +
                    '<i class="material-icons">delete_forever</i> Delete</button></span>');
            }
        });
        APP.grids.userTable = userTable;
        $(el).delegate('tr', 'click', function(e) {

            var data = userTable.row(this).data();
            APP.openUrlInPopup('/partialpages/addUpdateUser.php?id=' +
                data.user_id, 'Edit User', { height: 350, width: 500 });
        });

        $('.userGridContainer').delegate('#gridBtn_addUser', 'click', function(e) {
            APP.openUrlInPopup('/partialpages/addUpdateUser.php', 'Add User', { height: 350, width: 500 });
        });

        $(el).delegate('.gridCheck_user', 'click', function(e) {
            APP.openUrlInPopup('/partialpages/addUpdateUser.php?id=' +
                data.user_id, 'Add User', { height: 350, width: 500 });
            e.stopPropagation();
        });
    }
}

function addUpdateUser(e) {
    var formObj = $('form[name=addUpdateUserForm]');
    if (formObj.length > 0) {
        var reqUrl = APP.site + '/ajax.php?action=addUser';
        if ($(formObj).find('user_id').val() != '') {
            reqUrl = APP.site + '/ajax.php?action=updateUser';
        }
        $.ajax({
            url: reqUrl,
            data: $(formObj).serialize(),
            method: 'post',
            dataType: 'json',
            success: function(resp) {
                if (resp && resp.success && resp.success === true) {
                    try {
                        $('#viewerPopup').dialog('close');
                        APP.grids.userTable.ajax.reload();
                    } catch (e) {
                        //silently ignore;
                    }
                } else {
                    APP.showError("An error has occured while saving user details." + (resp.message ? '<br>' + resp.message : ''));
                }
            }
        });
    }
}