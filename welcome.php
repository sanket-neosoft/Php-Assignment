<!DOCTYPE html>
<html lang="en">
<?php include("includes/head.php"); ?>

<body>
    <div class="container content">
        <div class="row">
            <div class="col-md m-auto">
                <div class="container text-center">
                    <p class="display-4">Welcome to</p>
                    <img src="https://uilogos.co/img/logotype/earth.png" class="mx-atuo logotype" alt="">
                </div>
            </div>
            <div class="col-md m-auto shadow rounded">
                <div class="container text-left m-3">
                    <p>You are registered successfully with id : <?php echo $_GET["uid"]; ?></p>
                    <p>For login Click on: <a class="btn btn-success" href="index.php?uid=<?php echo $_GET["uid"]; ?>">Login</a></p>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap js jquery -->
    <?php include("includes/script.php"); ?>
    
</body>

</html>