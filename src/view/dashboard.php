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

    <div class="flex flex-row">
        <div class="w-1/2 justify-center items-center mx-4 my-2">
            <div class="text-3xl text-center mb-5">Master Data</div>
            <div class="text-2xl">Lecturer</div>
            <div class="form-control w-full max-w-xs">
                <div class="form-control pt-1">
                    <div class="input-group">
                        <input type="text" id="nameLecturer" placeholder="Lecturer's name" class="input input-bordered" />
                        <button class="btn" name="btn_insert" id="btnInsertLecturer">
                            Insert
                        </button>
                    </div>
                </div>
            </div>
            <div class="overflow-x-auto my-2">
                <table class="table table-compact w-1/2" id="tableLecturer">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Edit</th>
                        <th>Delete</th>
                    </tr>
                    </thead>
                    <tbody id="bodyLecturer">
                    </tbody>
                </table>
            </div>

            <hr/>

            <div class="text-2xl my-2">Activity</div>
            <div class="form-control w-full max-w-xs">
                <div class="form-control pt-1">
                    <div class="input-group">
                        <input type="text" id="nameActivity" placeholder="Activity's name" class="input input-bordered" />
                        <button class="btn" name="btn_insert" id="btnInsertActivity">
                            Insert
                        </button>
                    </div>
                </div>
            </div>
            <div class="overflow-x-auto my-2">
                <table class="table table-compact w-1/2" id="tableActivity">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Edit</th>
                        <th>Delete</th>
                    </tr>
                    </thead>
                    <tbody id="bodyActivity">
                    </tbody>
                </table>
            </div>

            <hr/>

            <div class="text-2xl my-2">Schedule</div>
            <div class="form-control w-full max-w-xs">
                <div class="form-control pt-1">
                    <div class="input-group">
                        <input type="text" id="timeSchedule" placeholder="Schedule's time" class="input input-bordered" />
                        <button class="btn" name="btn_insert" id="btnInsertSchedule">
                            Insert
                        </button>
                    </div>
                    <div>contoh : 08:00 - 16:30</div>
                </div>
            </div>
            <div class="overflow-x-auto my-2">
                <table class="table table-compact w-1/2" id="tableSchedule">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>Time</th>
                        <th>Edit</th>
                        <th>Delete</th>
                    </tr>
                    </thead>
                    <tbody id="bodySchedule">
                    </tbody>
                </table>
            </div>
        </div>
        <div class="w-1/2">
            <div class="text-3xl text-center mb-5">Data to OBS</div>
            <div class="text-2xl">Lecturer</div>
            <div class="form-control">
                <div class="input-group">
                    <select class="select select-bordered" id="selectLecturer"></select>
                    <button class="btn" id="saveLecturer">Save</button>
                </div>
            </div>
            <div class="text-lg my-4">Current Lecturer selected : <span id="lecturerSelected"></span></div>
            <hr/>
            <div class="text-2xl my-2">Activity</div>
            <div class="form-control">
                <div class="input-group">
                    <select class="select select-bordered" id="selectActivity"></select>
                    <button class="btn" id="saveActivity">Save</button>
                </div>
            </div>
            <div class="text-lg my-4">Current Activity selected : <span id="activitySelected"></span></div>
            <hr/>
            <div class="text-2xl my-2">Schedule</div>
            <div class="form-control">
                <div class="input-group">
                    <select class="select select-bordered" id="selectSchedule"></select>
                    <button class="btn" id="saveSchedule">Save</button>
                </div>
            </div>
            <div class="text-lg my-4">Current Schedule selected : <span id="scheduleSelected"></span></div>

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
    let updateID = -1
    let deleteType = ''
    let loadData = () => {
        // load lecturer
        $.ajax({
            method: "post",
            data: {
                table_name: 'lecturer',
            },
            url: "../controller/loadDataController.php",
            success: result => {
                if(result.indexOf("no data") >= 0) {
                    $("#bodyLecturer").append(`
                        <tr>
                            <td colspan="4" class="text-xl">No Data</td>
                        </tr>
                        `)
                }
                else {
                    fillTableLecturer(result)
                }
            }
        })

        // load activity
        $.ajax({
            method: "post",
            data: {
                table_name: 'activity',
            },
            url: "../controller/loadDataController.php",
            success: result => {
                console.log()
                if(result.indexOf("no data") >= 0) {
                    $("#bodyActivity").append(`
                        <tr>
                            <td colspan="4" class="text-xl">No Data</td>
                        </tr>
                        `)
                }
                else {
                    fillTableActivity(result)
                }
            }
        })

        // load schedule
        $.ajax({
            method: "post",
            data: {
                table_name: 'schedule',
            },
            url: "../controller/loadDataController.php",
            success: result => {
                console.log()
                if(result.indexOf("no data") >= 0) {
                    $("#bodySchedule").append(`
                        <tr>
                            <td colspan="4" class="text-xl">No Data</td>
                        </tr>
                        `)
                }
                else {
                    fillTableSchedule(result)
                }
            }
        })

        // load select lecturer
        $.ajax({
            method: "post",
            data: {
                table_name: 'lecturer',
            },
            url: "../controller/loadDataController.php",
            success: result => {
                if(result.indexOf("no data") < 0) {
                    fillSelectLecturer(result)
                }
            }
        })

        // load select activity
        $.ajax({
            method: "post",
            data: {
                table_name: 'activity',
            },
            url: "../controller/loadDataController.php",
            success: result => {
                if(result.indexOf("no data") < 0) {
                    fillSelectActivity(result)
                }
            }
        })

        // load select schedule
        $.ajax({
            method: "post",
            data: {
                table_name: 'schedule',
            },
            url: "../controller/loadDataController.php",
            success: result => {
                if(result.indexOf("no data") < 0) {
                    fillSelectSchedule(result)
                }
            }
        })

        // load selected data
        $.ajax({
            method: "post",
            url: "../controller/loadSelectDataController.php",
            success: result => {
                if(result.indexOf("no data") < 0) {
                    let decodeResult = JSON.parse(result)
                    $('#lecturerSelected').html(decodeResult.lecturer)
                    $('#activitySelected').html(decodeResult.activity)
                    $('#scheduleSelected').html(decodeResult.schedule)
                }
            }
        })
    }
    loadData()

    $('#btnInsertLecturer').on('click', () => {
        if($('#btnInsertLecturer').html() === 'Change') {
            $.ajax({
                method: "post",
                data: {
                    name: $('#nameLecturer').val(),
                    id: updateID,
                    btn_edit: "1",
                },
                url: "../controller/lecturerController.php",
                success: function(result){
                    $("#nameLecturer").val("")
                    $("#btnInsertLecturer").html('Insert')
                    $(`#btnEditLecturer${updateID}`).html('Edit')
                    alert('Lecturer\'s name Updated!')
                    fillTableLecturer(result)
                    fillSelectLecturer(result)
                }
            })
        }
        else {
            $.ajax({
                method: "post",
                data: {
                    name: $('#nameLecturer').val(),
                    btn_insert: "1",
                },
                url: "../controller/lecturerController.php",
                success: function(result){
                    $("#nameLecturer").val("")
                    alert('New Lecturer Added!')
                    fillTableLecturer(result)
                    fillSelectLecturer(result)
                }
            })
        }
    })

    $('#btnInsertActivity').on('click', () => {
        if($('#btnInsertActivity').html() === 'Change') {
            $.ajax({
                method: "post",
                data: {
                    name: $('#nameActivity').val(),
                    id: updateID,
                    btn_edit: "1",
                },
                url: "../controller/activityController.php",
                success: function(result){
                    $("#nameActivity").val("")
                    $("#btnInsertActivity").html('Insert')
                    $(`#btnEditActivity${updateID}`).html('Edit')
                    alert('Activity\'s name Updated!')
                    fillTableActivity(result)
                    fillSelectActivity(result)
                }
            })
        }
        else {
            $.ajax({
                method: "post",
                data: {
                    name: $('#nameActivity').val(),
                    btn_insert: "1",
                },
                url: "../controller/activityController.php",
                success: function(result){
                    $("#nameActivity").val("")
                    alert('New Activity Added!')
                    fillTableActivity(result)
                    fillSelectActivity(result)
                }
            })
        }
    })

    $('#btnInsertSchedule').on('click', () => {
        if($('#btnInsertSchedule').html() === 'Change') {
            $.ajax({
                method: "post",
                data: {
                    time: $('#timeSchedule').val(),
                    id: updateID,
                    btn_edit: "1",
                },
                url: "../controller/scheduleController.php",
                success: function(result){
                    $("#timeSchedule").val("")
                    $("#btnInsertSchedule").html('Insert')
                    $(`#btnEditSchedule${updateID}`).html('Edit')
                    alert('Schedule\'s time Updated!')
                    fillTableSchedule(result)
                    fillSelectSchedule(result)
                }
            })
        }
        else {
            $.ajax({
                method: "post",
                data: {
                    time: $('#timeSchedule').val(),
                    btn_insert: "1",
                },
                url: "../controller/scheduleController.php",
                success: function(result){
                    $("#timeSchedule").val("")
                    alert('New Schedule Added!')
                    fillTableSchedule(result)
                    fillSelectSchedule(result)
                }
            })
        }
    })

    $("#bodyLecturer").on('click', (e) => {
        if(e.target.id === `btnEditLecturer${e.target.value}`) {
            updateID = e.target.value
            let id = `#btnEditLecturer${e.target.value}`
            if($(id).html() === 'Edit') {
                $('[name=btn_edit_lecturer]').html('Edit')
                $('#nameLecturer').val($(id).parent().prev().html())
                $('#btnInsertLecturer').html('Change')
                $(id).html('Cancel')
            }
            else {
                $('#nameLecturer').val('')
                $('#btnInsertLecturer').html('Insert')
                $(id).html('Edit')
            }
        }
        else if(e.target.id === `labelDeleteLecturer${$(e.target).parent().val()}`) {
            deleteType = 'lecturer'
            updateID = $(e.target).parent().val()
            $('#deleteInfo').html(`
                <div class="text-lg">
                    Lecturer
                </div>
                <div class="text-md">
                    id : ${updateID}
                </div>
                <div class="text-md">
                    name : ${$(`#btnEditLecturer${updateID}`).parent().prev().html()}
                </div>
            `)
        }
    })

    $("#bodyActivity").on('click', (e) => {
        if(e.target.id === `btnEditActivity${e.target.value}`) {
            updateID = e.target.value
            let id = `#btnEditActivity${e.target.value}`
            if($(id).html() === 'Edit') {
                $('[name=btn_edit_activity]').html('Edit')
                $('#nameActivity').val($(id).parent().prev().html())
                $('#btnInsertActivity').html('Change')
                $(id).html('Cancel')
            }
            else {
                $('#nameActivity').val('')
                $('#btnInsertActivity').html('Insert')
                $(id).html('Edit')
            }
        }
        else if(e.target.id === `labelDeleteActivity${$(e.target).parent().val()}`) {
            deleteType = 'activity'
            updateID = $(e.target).parent().val()
            $('#deleteInfo').html(`
                <div class="text-lg">
                    Activity
                </div>
                <div class="text-md">
                    id : ${updateID}
                </div>
                <div class="text-md">
                    name : ${$(`#btnEditActivity${updateID}`).parent().prev().html()}
                </div>
            `)
        }
    })

    $("#bodySchedule").on('click', (e) => {
        if(e.target.id === `btnEditSchedule${e.target.value}`) {
            updateID = e.target.value
            let id = `#btnEditSchedule${e.target.value}`
            if($(id).html() === 'Edit') {
                $('[name=btn_edit_schedule]').html('Edit')
                $('#timeSchedule').val($(id).parent().prev().html())
                $('#btnInsertSchedule').html('Change')
                $(id).html('Cancel')
            }
            else {
                $('#timeSchedule').val('')
                $('#btnInsertSchedule').html('Insert')
                $(id).html('Edit')
            }
        }
        else if(e.target.id === `labelDeleteSchedule${$(e.target).parent().val()}`) {
            deleteType = 'schedule'
            updateID = $(e.target).parent().val()
            $('#deleteInfo').html(`
                <div class="text-lg">
                    Schedule
                </div>
                <div class="text-md">
                    id : ${updateID}
                </div>
                <div class="text-md">
                    name : ${$(`#btnEditSchedule${updateID}`).parent().prev().html()}
                </div>
            `)
        }
    })

    $("body").on('click', (e) => {
        if(e.target.id === 'btnYes') {
            $.ajax({
                method: "post",
                data: {
                    table_name: deleteType,
                    id: updateID,
                    btn_delete: 1,
                },
                url: `../controller/${deleteType}Controller.php`,
                success: result => {
                    if(result.indexOf("no data") >= 0) {
                        if(deleteType === 'lecturer') {
                            $("#bodyLecturer").html(`
                                <tr>
                                    <td colspan="4" class="text-xl">No Data</td>
                                </tr>
                            `)
                        }
                        else if(deleteType === 'activity') {
                            $("#bodyActivity").html(`
                                <tr>
                                    <td colspan="4" class="text-xl">No Data</td>
                                </tr>
                            `)
                        }
                        else if(deleteType === 'schedule') {
                            $("#bodySchedule").html(`
                                <tr>
                                    <td colspan="4" class="text-xl">No Data</td>
                                </tr>
                            `)
                        }
                    }
                    else {
                        if(deleteType === 'lecturer') {
                            fillTableLecturer(result)
                            fillSelectLecturer(result)
                        }
                        else if(deleteType === 'activity') {
                            fillTableActivity(result)
                            fillSelectActivity(result)
                        }
                        else if(deleteType === 'schedule') {
                            fillTableSchedule(result)
                            fillSelectSchedule(result)
                        }
                    }
                }
            })
        }
    })

    let fillTableLecturer = result => {
        let decodeResult = JSON.parse(result)
        $("#bodyLecturer").empty()
        decodeResult.forEach((row) => {
            $("#bodyLecturer").append(`
                <tr>
                    <td>${row.id}</td>
                    <td>${row.name}</td>
                    <td><button class="btn btn-sm" name="btn_edit_lecturer" id="btnEditLecturer${row.id}" value="${row.id}">Edit</button></td>
                    <td><button type="button" name="btn_delete" id="btnDeleteLecturer${row.id}" value="${row.id}"><label for="modalDelete" class="btn modal-button btn-sm" id="labelDeleteLecturer${row.id}">Delete</label></button></td>
                </tr>
            `)
        })
    }

    let fillTableActivity = result => {
        let decodeResult = JSON.parse(result)
        $("#bodyActivity").empty()
        decodeResult.forEach((row) => {
            $("#bodyActivity").append(`
                <tr>
                    <td>${row.id}</td>
                    <td>${row.name}</td>
                    <td><button class="btn btn-sm" name="btn_edit_activity" id="btnEditActivity${row.id}" value="${row.id}">Edit</button></td>
                    <td><button type="button" name="btn_delete" id="btnDeleteActivity${row.id}" value="${row.id}"><label for="modalDelete" class="btn modal-button btn-sm" id="labelDeleteActivity${row.id}">Delete</label></button></td>
                </tr>
            `)
        })
    }

    let fillTableSchedule = result => {
        let decodeResult = JSON.parse(result)
        $("#bodySchedule").empty()
        decodeResult.forEach((row) => {
            $("#bodySchedule").append(`
                <tr>
                    <td>${row.id}</td>
                    <td>${row.time}</td>
                    <td><button class="btn btn-sm" name="btn_edit_schedule" id="btnEditSchedule${row.id}" value="${row.id}">Edit</button></td>
                    <td><button type="button" name="btn_delete" id="btnDeleteSchedule${row.id}" value="${row.id}"><label for="modalDelete" class="btn modal-button btn-sm" id="labelDeleteSchedule${row.id}">Delete</label></button></td>
                </tr>
            `)
        })
    }

    $('#saveLecturer').on('click', e => {
        $.ajax({
            method: "post",
            data: {
                id: $('#selectLecturer').val(),
                btn_select: "1",
            },
            url: "../controller/lecturerController.php",
            success: function(result){
                $('#lecturerSelected').html(result)
                alert('Lecturer updated!')
                $('#defaultLecturer').remove()
                $("#selectLecturer").prepend('<option disabled selected id="defaultLecturer">Pick lecturer</option>')
            }
        })
    })

    $('#saveActivity').on('click', e => {
        $.ajax({
            method: "post",
            data: {
                id: $('#selectActivity').val(),
                btn_select: "1",
            },
            url: "../controller/activityController.php",
            success: function(result){
                $('#activitySelected').html(result)
                alert('Activity updated!')
                $('#defaultActivity').remove()
                $("#selectActivity").prepend('<option disabled selected id="defaultActivity">Pick activity</option>')
            }
        })
    })

    $('#saveSchedule').on('click', e => {
        $.ajax({
            method: "post",
            data: {
                id: $('#selectSchedule').val(),
                btn_select: "1",
            },
            url: "../controller/scheduleController.php",
            success: function(result){
                $('#scheduleSelected').html(result)
                alert('Schedule updated!')
                $('#defaultSchedule').remove()
                $("#selectSchedule").prepend('<option disabled selected id="defaultSchedule">Pick schedule</option>')
            }
        })
    })

    let fillSelectLecturer = result => {
        let decodeResult = JSON.parse(result)
        let $selectLecturer = $("#selectLecturer")
        $selectLecturer.empty()
        $selectLecturer.append('<option disabled selected id="defaultLecturer">Pick lecturer</option>')
        decodeResult.forEach((row) => {
            $selectLecturer.append(`<option value="${row.id}">${row.name}</option>`)
        })
    }

    let fillSelectActivity = result => {
        let decodeResult = JSON.parse(result)
        let $selectActivity = $("#selectActivity")
        $selectActivity.empty()
        $selectActivity.append('<option disabled selected id="defaultActivity">Pick activity</option>')
        decodeResult.forEach((row) => {
            $selectActivity.append(`<option value="${row.id}">${row.name}</option>`)
        })
    }

    let fillSelectSchedule = result => {
        let decodeResult = JSON.parse(result)
        let $selectSchedule = $("#selectSchedule")
        $selectSchedule.empty()
        $selectSchedule.append('<option disabled selected id="defaultSchedule">Pick schedule</option>')
        decodeResult.forEach((row) => {
            $selectSchedule.append(`<option value="${row.id}">${row.time}</option>`)
        })
    }

</script>
