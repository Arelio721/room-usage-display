<?php
session_start()
?>

<!DOCTYPE html>
<html data-theme="light">

<head>
    <title>Dashboard</title>
    <link rel="stylesheet" href="../../dist/output.css">
    <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
</head>

<body>
<div class="w-full h-screen flex flex-col justify-start">
    <?php include_once "../component/navbar.php"; ?>

    <div class="flex">
        <div class="w-full justify-center items-center mx-4 my-2">
            <div class="text-2xl">Admin</div>
            <div class="form-control w-full max-w-xs">
                <label class="label">
                    <span class="label-text">Username</span>
                </label>
                <input type="text" placeholder="" id="usernameAdmin" class="input input-bordered w-full max-w-xs" />
                <label class="label">
                    <span class="label-text">Password</span>
                </label>
                <input type="text" placeholder="" id="passwordAdmin" class="input input-bordered w-full max-w-xs" />
                <label class="label">
                    <span class="label-text">Room Name</span>
                </label>
                <input type="text" placeholder="" id="roomnameAdmin" class="input input-bordered w-full max-w-xs" />
                <input type="hidden" placeholder="" id="oldUsernameAdmin" class="input input-bordered w-full max-w-xs" />
            </div>
            <button class="btn mt-4" name="btn_insert" id="btnInsertAdmin">Insert</button>
            <div class="overflow-x-auto my-3">
                <table class="table table-compact w-1/2" id="tableAdmin">
                    <thead>
                    <tr>
                        <th>Username</th>
                        <th>Password</th>
                        <th>Room Name</th>
                        <th>Edit</th>
                        <th>Delete</th>
                    </tr>
                    </thead>
                    <tbody id="bodyAdmin">
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <?php include_once "../component/footer.php" ?>
</div>

<input type="checkbox" id="modalDelete" class="modal-toggle" />
<label for="modalDelete" class="modal cursor-pointer">
    <label class="modal-box relative" for="">
        <h3 class="text-xl font-bold">Are you sure want to delete?</h3>
        <div class="py-4" id="deleteInfo"></div>
        <div class="flex flex-row justify-end">
            <div class="modal-action mr-5">
                <label for="modalDelete" class="btn">No</label>
            </div>
            <div class="modal-action">
                <label for="modalDelete" class="btn bg-red-600" id="btnYes">Yes</label>
            </div>
        </div>
    </label>
</label>
</body>

</html>

<script>
    let updateUsername = ""
    let loadData = () => {
        // load admin
        $.ajax({
            method: "post",
            data: {
                table_name: 'admin',
            },
            url: "../controller/loadDataController.php",
            success: result => {
                if(result.indexOf("no data") >= 0) {
                    $("#bodyAdmin").append(`
                        <tr>
                            <td colspan="4" class="text-xl">No Data</td>
                        </tr>
                        `)
                }
                else {
                    fillTableAdmin(result)
                }
            }
        })
    }
    loadData()

    $('#btnInsertAdmin').on('click', () => {
        if($('#btnInsertAdmin').html() === 'Change') {
            $.ajax({
                method: "post",
                data: {
                    username: $('#usernameAdmin').val(),
                    password: $('#passwordAdmin').val(),
                    room_name: $('#roomnameAdmin').val(),
                    old_username: $('#oldUsernameAdmin').val(),
                    btn_edit: "1",
                },
                url: "../controller/adminController.php",
                success: function(result){
                    $("#usernameAdmin").val("")
                    $("#passwordAdmin").val("")
                    $("#roomnameAdmin").val("")
                    $("#btnInsertAdmin").html('Insert')
                    $(`#btnEditAdmin${updateUsername}`).html('Edit')
                    alert('Admin\'s name Updated!')
                    fillTableAdmin(result)
                }
            })
        }
        else {
            $.ajax({
                method: "post",
                data: {
                    username: $('#usernameAdmin').val(),
                    password: $('#passwordAdmin').val(),
                    room_name: $('#roomnameAdmin').val(),
                    btn_insert: "1",
                },
                url: "../controller/adminController.php",
                success: function(result){
                    $("#usernameAdmin").val("")
                    $("#passwordAdmin").val("")
                    $("#roomnameAdmin").val("")
                    alert('New Admin Added!')
                    fillTableAdmin(result)
                }
            })
        }
    })

    $("#bodyAdmin").on('click', (e) => {
        if(e.target.id === `btnEditAdmin${e.target.value}`) {
            updateUsername = e.target.value
            let username = `#btnEditAdmin${e.target.value}`
            if($(username).html() === 'Edit') {
                $('[name=btn_edit_admin]').html('Edit')
                $('#roomnameAdmin').val($(username).parent().prev().html())
                $("#passwordAdmin").val($(username).parent().prev().prev().html())
                $("#usernameAdmin").val($(username).parent().prev().prev().prev().html())
                $("#oldUsernameAdmin").val($(username).parent().prev().prev().prev().html())
                $('#btnInsertAdmin').html('Change')
                $(username).html('Cancel')
            }
            else {
                $("#usernameAdmin").val("")
                $("#passwordAdmin").val("")
                $("#roomnameAdmin").val("")
                $('#btnInsertAdmin').html('Insert')
                $(username).html('Edit')
            }
        }
        else if(e.target.id === `labelDeleteAdmin${$(e.target).parent().val()}`) {
            updateUsername = $(e.target).parent().val()
            $('#deleteInfo').html(`
                <div class="text-lg">
                    Admin
                </div>
                <div class="text-md">
                    username : ${updateUsername}
                </div>
                <div class="text-md">
                    password : ${$(`#btnEditAdmin${updateUsername}`).parent().prev().prev().html()}
                </div>
                <div class="text-md">
                    room name : ${$(`#btnEditAdmin${updateUsername}`).parent().prev().html()}
                </div>
            `)
        }
    })

    $("body").on('click', (e) => {
        if(e.target.id === 'btnYes') {
            $.ajax({
                method: "post",
                data: {
                    username: updateUsername,
                    btn_delete: 1,
                },
                url: `../controller/adminController.php`,
                success: result => {
                    if(result.indexOf("no data") >= 0) {
                        $("#bodyAdmin").html(`
                                <tr>
                                    <td colspan="4" class="text-xl">No Data</td>
                                </tr>
                            `)
                    }
                    else {
                        fillTableAdmin(result)
                    }
                }
            })
        }
    })

    let fillTableAdmin = result => {
        let decodeResult = JSON.parse(result)
        $("#bodyAdmin").empty()
        decodeResult.forEach((row) => {
            $("#bodyAdmin").append(`
                <tr>
                    <td>${row.username}</td>
                    <td>${row.password}</td>
                    <td>${row.room_name}</td>
                    <td><button class="btn btn-sm" name="btn_edit_admin" id="btnEditAdmin${row.username}" value="${row.username}">Edit</button></td>
                    <td><button type="button" name="btn_delete" id="btnDeleteAdmin${row.username}" value="${row.username}"><label for="modalDelete" class="btn modal-button btn-sm" id="labelDeleteAdmin${row.username}">Delete</label></button></td>
                </tr>
            `)
        })
    }

</script>
