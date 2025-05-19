<?php
    require "../models/User.php";
    require "../database/Database.php";
    $db = new Database();
    $conn = $db->getConnection();
    User::setConnection($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>logout</title>
            <!-- bootstrap CSS -->
            <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">  

            <!-- SweetAlert2 JS -->
            <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body id="login">

    <style>
        body#login {
            background: #061F5C;
            background: linear-gradient(90deg,rgba(6, 31, 92, 1) 0%, rgba(87, 199, 133, 1) 100%, rgba(237, 221, 83, 1) 100%);
        }
    </style>

<?php

    session_start();
    
    if(isset($_SESSION["email"])){
        header("Location: ../");
    }


    if($_SERVER["REQUEST_METHOD"] == "POST"){

        $user = User::findByEmail($_POST['email']);

        if($user && $user->status == "inactive" && password_verify($_POST['password'], $user->password)){
            $_SESSION['error'] = "Account is deactivated!, cannot login!";
            header("Location: login.php");
            exit();
        }

        if($user){
            if(password_verify($_POST['password'], $user->password)){
            
            $_SESSION["role"] = $user->role;
            $_SESSION["email"] = $user->email;
            $_SESSION["name"] = $user->name;
            $_SESSION["userID"] = $user->id;

            echo '<script>
            Swal.fire({
                title: "Login Successfully!",
                icon: "success",
                iconColor: "#0b7b55",
                showConfirmButton: false,
                timer: 1500,
                timerProgressBar: true
            }).then(function() {
                window.location.href = "../";
            });
            </script>';

            

            }else{
                $_SESSION['error'] = "Invalid email or password";
            }
        }else{
            $_SESSION['error'] = "Invalid email or password";
        }
    }


?>
            
            <div class="container-xxl d-flex justify-content-center align-items-center" style="min-height: 120vh;">
                
                

                <div class="card w-100 rounded-5" style="max-width: 500px; height: 600x;">
                    <div class="card-body">
                        <div style="position: absolute; left: 35%; bottom: 87%;">
                        <img src="../images/assets/logo.png" alt="Logo" style="width: 150px; height: auto; border-radius: 50%;">
                        </div>
                        <div class="d-flex justify-content-center">
                            <h1 class="fw-bold mt-5" style="color: #064e3b; font-size: 60px;">WELCOME!</h1>
                        </div>
                        <div class="d-flex justify-content-center mb-4">
                            <h3 class="fw-bold mt-2" style="color: #064e3b; font-size: 35px;">Log in to your account.</h3>
                        </div>
                        <form action="login.php" method="POST">
                            <div class="row">
                                <div class="col-md-10 mb-3 mx-auto">
                                    <label for="email" class="form-label">E-mail Address</label>
                                    <input type="email" class="form-control border-3 border-top-0 border-end-0 border-start-0 border-emphasis rounded-0 shadow-none outline-0" id="email" name="email" required >
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-10 mb-3 mx-auto">
                                    <label for="password" class="form-label">Password</label>
                                    <input type="password" class="form-control border-3 border-top-0 border-end-0 border-start-0 border-emphasis rounded-0 shadow-none" id="password" name="password" required>
                                </div>
                            </div>
                                <?php if(isset($_SESSION['error'])): ?>
                                    <div class="row">
                                        <div class="col-md-10 mx-auto">
                                            <div class="alert alert-danger mt-3" role="alert">
                                                <?= $_SESSION['error'] ?>
                                            </div>
                                        </div>
                                    </div>

                                    <?php unset($_SESSION['error']); 
                                        endif; 
                                    ?>
                            <div class="row">
                                <div class="col-md-12 d-flex justify-content-center my-3">
                                    <button type="submit" class="btn rounded-5 fw-bold fs-3 text-white" style="width: 200px; height: 60px; background-color: #7096d1;">LOG IN</button>
                                </div>
                            </div>

                            

                        </form>    
                    </div>
                </div>
            </div>
            
            <!-- bootstrap js -->
            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

            </body>
            </html>



