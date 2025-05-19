<?php
    require "../database/Database.php";
    require "../models/User.php"; 

        $db = new Database();
        $conn = $db->getConnection();
        User::setConnection($conn);
        ob_start();
        session_start();

        if(!isset($_SESSION['email'])){
            header("Location: ../auth/login.php");
            exit();
        }

        if($_SESSION['role'] == 'instructor'){
        header("Location: ../");
        exit();
        }

        if(!isset($_GET['id'])){
            header("Location: index.php");
            exit();
        }
        
        include "../layout/header.php";
        include "../layout/sidebar.php";

        $user = User::find($_GET['id']);

        if(empty($user)){
            http_response_code(404);
            include "../ErrorCode/404.php";
            exit;
        }

        $_SESSION['oldemail'] = $user -> email;

        if($user->role == 'super-admin' || ($user->role == 'admin' && $_SESSION['role'] == 'admin')){
            header("Location: index.php");
            exit();
        }
?>

<?php
        if(isset($_SESSION['success'])){
            echo '<script> 
                Swal.fire({
                    title: "Success!",
                    text: "'.$_SESSION['success'].'",
                    icon: "success",
                    iconColor: "#0b7b55",
                    }).then(function() {
                        window.location = "index.php";
                });
            </script>';
        }
        unset($_SESSION['success']);

        if(isset($_SESSION['error'])){
            echo '<script>
                Swal.fire({
                    title: "Error!",
                    text: "'.$_SESSION['error'].'",
                    icon: "error",
                    iconColor: "#b91c1c",
                });
            </script>';
        }
        unset($_SESSION['error']);
?>

<?php

    if(($_SESSION['role']) == 'admin' && ($user -> role == 'super-admin' || $user -> role == 'admin')){
        header("Location: index.php");
        exit();
    }    
?>

    <div class = "container-xxl bg-white rounded-start-5 p-5" style="max-width: 100%; height: 120vh;">

        <div class="card mx-auto border-0" style="max-width: 90%; height: 100%;">

          
            <div class="card-body">

            <h1 class="fw-bold" style="color: #061f5c; font-size: 60px; margin-top: 25px">USER MANAGEMENT</h1>
            <h3 class="fw-bold" style="color: #061f5c; font-size: 30px; margin-bottom: 3%;">UPDATE STUDENT RECORD</h3>

                <form action="update.php" method="POST">
                    <input type="hidden" name="id" value="<?= $user -> id ?>">
                    <div class = "row">
                        <div class = "col-md-5 mb-3">
                            <label for="name" class="form-label fs-4">Name</label>
                            <input type="text" class="form-control border-0 border-bottom rounded-0 border-black shadow-none fs-5" id="name" name="name" value='<?= $user -> name ?>' required>
                        </div>
                        <div class = "col-md-5 mb-3">
                            <label for="email" class="form-label fs-4">Email address</label>
                            <input type="email" class="form-control border-0 border-bottom rounded-0 border-black shadow-none fs-5" id="email" name="email" value='<?= $user -> email ?>'required>
                        </div>
                    </div>
                    <div class = "row">
                        
                        <div class = "col-md-5 mb-3">
                            <label for="role" class="form-label fs-4">Role</label>
                            <select class="form-select border-0 border-bottom rounded-0 border-black shadow-none fs-5" id="role" name="role" required>
                                
                            <?php if($_SESSION['role'] == "admin"): ?>
                                <option value = "instructor" <?= $user -> role == "instructor" ? 'selected' : NULL ?>>Instructor</option>
                            <?php else: ?>
                                <option value = "admin" <?= $user -> role === "admin" ? 'selected' : NULL ?>>Admin</option>
                                <option value = "instructor" <?= $user -> role == "instructor" ? 'selected' : NULL ?>>Instructor</option>
                            <?php endif; ?>

                            </select>
                        </div>
                    </div>
                    
                    <div class = "mb-3" style="margin-right: 5%;">          
                        <input type="submit" name="temppassreset" Value="Generate Temporary Password to Reset Password" class="text-secondary btn btn-link">
                    </div> 

                    <div class = "row" style="width: 250px; margin-left: -2px;">
                            <button type="submit" class="btn fw-bold text-white rounded-5 mt-3" style="background-color: #0b7b55">Update</button>
                            <a href="index.php" class="btn fw-bold btn-secondary mt-2 rounded-5">Cancel</a>
                    </div>
                </form>    
            </div>
        </div>
    </div>


<?php ob_end_flush();
include "../layout/footer.php"; ?>