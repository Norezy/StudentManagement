<?php
    require "../database/Database.php";
    require "../models/User.php"; 

        $db = new Database();
        $conn = $db->getConnection();
        User::setConnection($conn);
        session_start();

?>

<?php   
    include "../layout/header.php";
    include "../layout/sidebar.php";
?>

<?php
        if(!isset($_SESSION['email'])){
            header("Location: ../auth/login.php");
            exit();
        }

        if($_SESSION['userID'] != $_GET['id']){
            header("Location: ../");
            exit();
        }
        
        $user = User::find($_GET['id']);

        if(empty($user)){
            http_response_code(404);
            include "404.php";
            exit;
        }

        $_SESSION['oldemail'] = $user -> email;

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
                    icon: "error"
                });
            </script>';
        }
        
        unset($_SESSION['error']);
?>

    <div class = "container-xxl bg-white rounded-start-5 p-5" style="max-width: 100%; height: 120vh;">
        <div class="card mx-auto border-0" style="max-width: 90%; height: 100%;">
            <div class="card-body">
                
                <h1 class="fw-bold" style="color: #061f5c; font-size: 60px; margin-top: 25px">PROFILE</h1>
                <h3 class="fw-bold" style="color: #061f5c; font-size: 30px; margin-bottom: 3%;">UPDATE PASSWORD</h3>
                <form action="update.php" method="POST">
                    <input type="hidden" name="id" value="<?=$user -> id?>">
                    <div class = "row">
                        <div class = "col-md-6 mb-3">
                            <label for="oldpassword" class="form-label fs-4">Old Password</label>
                            <input type="password" class="form-control border-0 border-bottom rounded-0 border-black shadow-none fs-5" id="oldpassword" name="oldpassword" required>
                        </div>
                    </div>

                    <div class = "row">
                        <div class = "col-md-6 mb-3">
                            <label for="password" class="form-label fs-4">New Password</label>
                            <input type="password" class="form-control border-0 border-bottom rounded-0 border-black shadow-none fs-5" id="password" name="password" required>
                        </div>
                    </div>

                    <div class = "row">
                        <div class = "col-md-6 mb-3">
                            <label for="cpassword" class="form-label fs-4">Confirm New Password</label>
                            <input type="password" class="form-control border-0 border-bottom rounded-0 border-black shadow-none fs-5" id="cpassword" name="cpassword" required>
                        </div>
                    </div>
                    
                    
                    <div class = "mb-3">          
                        <a href="edit.php?id=<?=$user -> id?>" class="text-secondary">Return to edit</a>
                    </div> 
                    

                    <div class = "row" style="width: 250px; margin-left: -2px;">
                            <input type="submit" name="passreset" value="Reset Password" class="btn fw-bold text-white rounded-5 mt-3" style="background-color: #0b7b55">
                            <a href="index.php" class="btn fw-bold btn-secondary mt-2 rounded-5">Cancel</a>
                    </div>

                </form>    
            </div>
        </div>
    </div>


<?php include "../layout/footer.php"; ?>