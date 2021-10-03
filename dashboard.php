<?php
error_reporting(0);

// session and details fetching from details.txt
session_start();
$email  = $_SESSION["email"];
$file = fopen("user/$email/details.txt", "r");
$username = trim(fgets($file));
$password = trim(fgets($file));
$name = trim(fgets($file));
$age = trim(fgets($file));
$gender = trim(fgets($file));
$image_path = trim(fgets($file));

// session login logic 
if (empty($email)) {
    header("location: index.php");
} 

// trim function 
function input_field($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
?>

<!doctype html>
<html lang="en">

<!-- head tag -->
<?php include("includes/head.php"); ?>

<body class="body">
    <div class="">
        <section class="vertical-nav bg-dark text-light shadow p-0" id="sidebar">
            <div class="text-center py-5 mt-4" id="sidebar">
                <img src="user/<?php echo $email; ?>/<?php echo $image_path; ?>" width="125px" height="125px" class=" my-3 rounded-circle img-thumbnail shadow-sm" alt="">
                <p class="text-success lead font-weight-bold text-uppercase"><?php echo $name; ?></p>
                <div class="my-4">
                    <p class="lead">Age: <?php echo $age; ?></p>
                    <p class="lead">Gender: <?php echo $gender; ?></p>
                </div>
                <a href="?p=chng_img" class="btn btn-success">Change Image</a>
            </div>
        </section>
        <section class="page_content" id="content">
            <nav class="navbar navbar-expand-lg fixed-top navbar-light bg-light shadow">
                <!-- Toggle button -->
                <button id="sidebarCollapse" type="button" class="btn btn-outline-success mr-3"><i class="bi bi-list"></i></button>
                <!-- logo -->
                <a class="navbar-brand mx-3" href="?p=home"><img src="https://uilogos.co/img/logomark/earth.png" width="30px" alt=""></a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item mx-3">
                            <a class="nav-link" href="?p=home">Home</a>
                        </li>
                        <li class="nav-item mx-3">
                            <a class="nav-link" href="?p=chng_pass">Change Password</a>
                        </li>
                        <li class="nav-item mx-3">
                            <a class="nav-link">Welcome: <?php echo $email; ?></a>
                        </li>
                        <li class="nav-item ml-3">
                            <a class="btn btn-success my-2 my-sm-0" href="logout.php">Log out</a>
                        </li>
                    </ul>
                </div>
            </nav>
            <div class="page_section">
                <div class="page">
                    <?php
                    switch ($_GET["p"]) {
                        case "home":
                            include("includes/home.php");
                            break;
                        case "chng_img":
                            include("includes/chng_img.php");
                            break;
                        case "chng_pass":
                            include("includes/chng_pass.php");
                            break;
                        default:
                            include("includes/home.php");
                    }
                    ?>
                </div>
            </div>
        </section>
    </div>

    <!-- Bootstrap js jquery -->
    <?php include("includes/script.php"); ?>

    <script>
        $(() => {
            $("#sidebarCollapse").on("click", () => {
                $("#sidebar, #content").toggleClass("active");
            });
        })
    </script>

</body>

</html>