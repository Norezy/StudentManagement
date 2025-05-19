<?php 

    require "../database/Database.php";
    require "../models/User.php";
    include '../layout/header.php';

    $db = new Database();
    $conn = $db->getConnection();
    User::setConnection($conn);
    
    session_start();
    

?>


<!-- check if user is logged in and if the user is a instructor the user will be sent back to index.php -->
<?php

    if(!isset($_SESSION['email'])){
        header("Location: ../auth/login.php");
        exit();
    }

    if($_SESSION['role'] == 'intructor'){
        header("Location: ../");
    }

?>



<?php

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    //check if password reset button is clicked    
        if(isset($_POST['temppassreset'])){

            $user = User::find($_POST['id']);
            $temppassword = User::generateRandomString(8);
            $user->password = password_hash($temppassword, PASSWORD_DEFAULT);
            $stmt = $user->save();

            if($stmt){
                echo '<div class = "container-xxl bg-white" style="max-width: 100%; height: 120vh;"></div>';
                echo '<script> 

                        Swal.fire({
                        title: "Saved!",
                        html: "Password Has been Reset Successfully! <br> your new password is: <strong>' . $temppassword . '</strong>",
                        icon: "success",
                        timer: 25000,
                        timerProgressBar: true,
                        }).then(function() {
                            window.location = "index.php";
                        });
                        
                    </script>';
            }else{
               $_SESSION['error'] = "Failed to update Password, please try again!";
                header("Location: edit.php?id=" . $_POST['id']);
            }
            exit();
        }
    //end of password reset button check



    //check if the email is the same as the old email and if the email is already in use
        $user = User::findByEmail($_POST['email']);

        if($_POST['email'] != $_SESSION['oldemail'] && $user){

            $_SESSION['error'] = "Email already in use!";
            unset($_SESSION['oldemail']);
            header("Location: edit.php?id=" . $_POST['id']);
            exit();

        }else{

            unset($_SESSION['oldemail']);

            $user = User::find($_POST['id']);

            $user->email = strtolower($_POST['email']);
            $user->name = ucwords(strtolower($_POST['name']));

            if($_SESSION['role'] == 'super-admin' || $_SESSION['role'] == 'admin'){
                $role = $_SESSION['role'];
            }else{
                $role = $_POST['role'];
            }

            $stmt = $user->save();

            if($stmt){
                $_SESSION['success'] = "User Has Been Updated Successfully!";
                header("Location: edit.php?id=" . $_POST['id']);
            }else{
                $_SESSION['error'] = "Failed to update User, please try again!";
                header("Location: edit.php?id=" . $_POST['id']);
            }

        }  
}else{
        header("Location: index.php");
}

?>


<div class = "container-xxl bg-white rounded-start-5 " style="max-width: 100%; height: 120vh;">
</div>

<?php include '../layout/footer.php';  ?>