<div class="navbar bg-base-100">
    <div class="flex-1">
        <a class="btn btn-ghost normal-case text-xl">Tampilan Informasi Penggunaan Ruangan di ISTTS</a>
    </div>

    <div class="flex-none text-3xl">
        <?php
        if(isset($_GET['room_name'])) {
            $room_name = $_GET['room_name'];
            echo $room_name;
        }
        ?>
    </div>

    <div class="navbar-end">
        <?php
        if(isset($_GET['room_name'])) {
        ?>
            <a class="btn bg-red-600" href="../index.php">Logout</a>
        <?php
        }
        ?>
    </div>
</div>