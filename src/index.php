<?php
session_start()
?>

<!DOCTYPE html>
<html data-theme="light">

<head>
    <title>Login</title>
    <link rel="stylesheet" href="../dist/output.css">
</head>

<body>
<div class="w-full h-screen flex flex-col justify-start">
    <?php
    $route = "";
    include_once "./component/navbar.php";
    ?>

    <div class="w-full h-full flex justify-center items-center">
        <div class="card flex-shrink-0 w-full max-w-sm shadow-xl bg-base-100 ">
            <form class="card-body" method="post" action="./controller/accountController.php">
                <div class="form-control">
                    <label class="label">
                        <span class="label-text">Username</span>
                    </label>
                    <input type="text" placeholder="username" class="input input-bordered" name="username" />
                </div>
                <div class="form-control">
                    <label class="label">
                        <span class="label-text">Password</span>
                    </label>
                    <input type="text" placeholder="password" class="input input-bordered" name="password" />
                </div>
                <div class="form-control mt-6">
                    <button class="btn btn-primary" type="submit">Login</button>
                </div>
            </form>
        </div>
    </div>

    <?php include_once "./component/footer.php" ?>
</div>
</body>

</html>