<?php
include '../config/Database.php';
include 'helpers/Helper.php';

session_start();

/* check user if login id */
if (isset($_SESSION['id']) && $_SESSION['is_logined'] == true) {
    header('location:dashboard.php');
}


if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $email    = inputValidate($_POST['email']);
    $password = inputValidate($_POST['password']);


    if (empty($email)) {
        $error['email'] = 'Email is required';
    } else {
        $data['email'] = $email;
    }
    if (empty($password)) {
        $error['password'] = 'Password is required';
    } else {
        $data['password'] = $password;
    }

    if (empty($error['email']) && empty($error['password'])) {

        $sql = "SELECT * FROM admin WHERE email=:email";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':email', $data['email'], PDO::PARAM_STR);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_OBJ);

        if ($row) {


            if (password_verify($data['password'], $row->password)) {

                $_SESSION['username']    = $row->name;
                $_SESSION['id']          = $row->id;
                $_SESSION['is_logined']  = true;

                header('location:dashboard.php');
            } else {
                $error['password'] = 'Password does not match';
            }
        } else {
            $error['email'] = 'Email not found';
        }
    }
}




?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>SB Admin 2 - Login</title>

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.css" rel="stylesheet">

</head>

<body class="">

    <div class="container">

        <!-- Outer Row -->
        <div class="row justify-content-center">

            <div class="col-xl-10 col-lg-12 col-md-9">

                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <!-- Nested Row within Card Body -->
                        <div class="row">
                            <div class="col-lg-6 d-none d-lg-block bg-login-image"></div>
                            <div class="col-lg-6">
                                <div class="p-5">
                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-4">Welcome Back!</h1>
                                    </div>
                                    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="post" class="user">
                                        <div class="form-group">
                                            <input type="email" name="email" value="<?php echo $data['email'] ?? ''; ?>" class="form-control form-control-user" id="exampleInputEmail" aria-describedby="emailHelp" placeholder="Enter Email Address...">
                                            <span class="text-danger"><?php echo $error['email'] ?? ''; ?></span>
                                        </div>
                                        <div class="form-group">
                                            <input type="password" name="password" class="form-control form-control-user" id="exampleInputPassword" placeholder="Password">
                                            <span class="text-danger"><?php echo $error['password'] ?? ''; ?></span>
                                        </div>
                                        <div class="form-group">
                                            <div class="custom-control custom-checkbox small">
                                                <input type="checkbox" class="custom-control-input" id="customCheck">
                                                <label class="custom-control-label" for="customCheck">Remember
                                                    Me</label>
                                            </div>
                                        </div>
                                        <button type="submit" name="login" class="btn btn-primary btn-user btn-block">
                                            Login
                                        </button>

                                    </form>
                                    <hr>
                                    <div class="text-center">
                                        <a class="small" href="forgot-password.html">Forgot Password?</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>

    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>

</body>

</html>