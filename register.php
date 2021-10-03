<?php
error_reporting(0);

// session login logic
if (isset($_SESSION["email"])) {
    header("location: dashboard.php");
}

include("includes/captcha.php");

// input fields 
$name = input_field($_POST["name"]);
$email = input_field($_POST["email"]);
$username = input_field($_POST["username"]);
$password = input_field($_POST["password"]);
$image = input_field($_POST["image"]);
$age = $_POST["age"];
$gender = input_field($_POST["gender"]);
$captcha = input_field($_POST["captcha"]);
$captchaHidden = input_field($_POST["captcha_hidden"]);

// image files variables
$tmp = $_FILES["image"]["tmp_name"];
$iname = $_FILES["image"]["name"];

// error variables 
$nameErr = $emailErr = $usernameErr = $passwordErr = $imageErr = $ageErr = $genderErr = $captchaErr = "";

// validation
if (isset($_POST["sub"])) {

    // name validation 
    if (empty($name)) {
        $nameErr = "Name is required.";
    } else if (!preg_match("/^[a-zA-Z ]+$/", $name)) {
        $nameErr = "Only Characters and white spaces are allowed.";
    }

    // email validation 
    if (empty($email)) {
        $emailErr = "Email Address is required.";
    } else if (!preg_match("/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/", $email)) {
        $emailErr = "Invalid Email Address.";
    }

    // username validation 
    if (empty($username)) {
        $usernameErr = "Username is required.";
    } else if (!preg_match("/^[a-z0-9_]+$/", $username)) {
        $usernameErr = "Only Small Characters, Numbers and \"_\" are allowed.";
    }

    // password validation 
    if (empty($password)) {
        $passwordErr = "Password is required.";
    } else if (!preg_match("/^[a-zA-Z0-9]{3,16}+$/", $password)) {
        $passwordErr = "Length of password should be between 4, 16 characters.";
    }

    // age validation 
    if (empty($age)) {
        $ageErr = "Please Enter your Age.";
    }

    // gender validation 
    if (empty($gender)) {
        $genderErr = "Please Select your Gender.";
    }

    // image validation 
    if (empty($image)) {
        $imageErr = "Please select png, jpg or jpeg file.";
    }

    // captcha validation 
    if (empty($captcha)) {
        $captchaErr = "Please Enter Captcha.";
    }

    $ext = pathinfo($iname, PATHINFO_EXTENSION);
    $fn =  "attach-" . rand() . "-" . time() . "." . $ext;

    // creating details.txt file for storing information and uploading img file in email folder
    if ($nameErr === "" && $emailErr === "" && $usernameErr === "" && $passwordErr === ""  && $ageErr === "" && $genderErr === "" && $captchaErr === "") {
        if ($captcha == $captchaHidden) {
            if (is_dir("user/" . $email)) {
                $emailErr = "Email id already registered.";
            } else if ($ext == "jpg" || $ext == "png" || $ext == "jpeg") {
                mkdir("user/$email");
                $pass = substr(sha1($password), 5, 10);
                file_put_contents("user/$email/" . "details.txt", $username . "\n" . $pass . "\n" . $name . "\n" . $age . "\n" . $gender . "\n" . $fn);
                if (move_uploaded_file($tmp, "user/$email/$fn")) {
                    header("location: welcome.php?uid=$email");
                    exit();
                } else {
                    $msg = "<div id='alert' class='alert alert-danger position-absolute start-50 top-50 translate-middle w-50 text-center'>File upload Failed</div>";
                }
            } else {
                $imageErr = "Please Select image file png, jpg or jpeg";
            }
        } else {
            $captchaErr = "Please Enter valid Captcha.";
        }
    } else {
        // 
    }
}

if (isset($_POST["already_exist"])) {
    header("Location: index.php");
    exit();
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

<?php include("includes/head.php"); ?>

<body>
    <div class="container">
        <form class="form p-4 my-5 bg-white border rounded shadow" method="POST" enctype="multipart/form-data">
            <div class="row">
                <div class="text-center">
                    <img src="https://uilogos.co/img/logomark/earth.png" class="mb-2" alt="" width="50px" height="">
                    <small class="font-weight-ligh font-italic d-block">Earth is what we all have in common.</small>
                    <hr>
                </div>
                <h4 class="py-3 text-success">Register</h4>
                <div class="form-group col-md-6 col-sm-12">
                    <label for="name">Name</label>
                    <input type="text" class="form-control" id="name" name="name" placeholder="Enter name">
                    <small id="err" class="form-text text-danger"><?php echo $nameErr; ?></small>
                </div>
                <div class="form-group col-md-6 col-sm-12">
                    <label for="email">Email address</label>
                    <input type="text" class="form-control" id="email" name="email" placeholder="Enter email">
                    <small id="err" class="form-text text-danger"><?php echo $emailErr; ?></small>
                </div>
                <div class="form-group col-md-6 col-sm-12">
                    <label for="username">Username</label>
                    <input type="text" class="form-control" id="username" name="username" placeholder="Enter username">
                    <small id="err" class="form-text text-danger"><?php echo $usernameErr; ?></small>
                </div>
                <div class="form-group col-md-6 col-sm-12">
                    <label for="password">Password</label>
                    <input type="password" class="form-control" id="password" name="password" placeholder="Enter password">
                    <small id="err" class="form-text text-danger"><?php echo $passwordErr; ?></small>
                </div>
                <div class="form-group col-md-6 col-sm-12">
                    <label for="age">Age</label>
                    <input type="number" class="form-control" id="age" name="age" placeholder="Enter age">
                    <small id="err" class="form-text text-danger"><?php echo $ageErr; ?></small>
                </div>
                <div class="form-group col-md-6 col-sm-12">
                    <label for="image">Image</label>
                    <input type="file" class="form-control" id="image" name="image">
                    <small id="err" class="form-text text-danger"><?php echo $imageErr; ?></small>
                </div>
                <div class="form-group col-md-6 col-sm-12">
                    <label for="gender">Gender</label>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="gender" id="gender" value="Male">
                        <label class="form-check-label" for="gender">
                            Male
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="gender" id="gender" value="Female">
                        <label class="form-check-label" for="gender">
                            Female
                        </label>
                    </div>
                    <small id="err" class="form-text text-danger"><?php echo $genderErr; ?></small>
                </div>
                <div class="form-group col-md-6 col-sm-12">
                    <label for="image">Captcha: <?php echo $pattern; ?></label>
                    <input type="text" class="form-control" id="captcha" name="captcha">
                    <input type="hidden" class="form-control" id="captcha_hidden" name="captcha_hidden" value="<?php echo $capsum; ?>">
                    <small id="err" class="form-text text-danger"><?php echo $captchaErr; ?></small>
                </div>
            </div>
            <div class="row">
                <div class="col-sm mb-2">
                    <button type="submit" class="btn btn-success btn-block" name="sub">Register</button>
                </div>
                <div class="col-sm mb-2">
                    <button type="submit" class="btn btn-dark btn-block" name="already_exist">Already a user</button>
                </div>
            </div>
        </form>
        <?php echo $msg; ?>
    </div>

    <!-- Bootstrap js jquery -->
    <?php include("includes/script.php"); ?>

    <script>
        $(() => {
            window.setTimeout(() => {
                $("#alert").fadeOut(1000);
            }, 2000);
        });
    </script>

</body>

</html>