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

        if(isset($_POST['passreset'])){
            $user = User::find($_POST['id']);
            //check if the password is the same as the old password
            if(password_verify($_POST['oldpassword'], $user->password)){
                if($_POST['password'] == $_POST['cpassword']){

                    $user->password = password_hash($_POST['password'], PASSWORD_DEFAULT);
                    $stmt = $user->save();

                    if($stmt){
                        $_SESSION['success'] = "Password has been updated successfully!";
                        header("Location: password.php?id=" . $_POST['id']);
                    }else{
                        $_SESSION['error'] = "Failed to update Password, please try again!";
                        header("Location: password.php?id=" . $_POST['id']);
                    }

                }else{
                    $_SESSION['error'] = "Password does not match!";
                    header("Location: password.php?id=" . $_POST['id']);
                }
            }else{
                $_SESSION['error'] = "Old Password is incorrect!";
                header("Location: password.php?id=" . $_POST['id']);
            }
            exit();
        }

    //check if the email is the same as the old email and if the email is already in use
        $user = User::findByEmail($_POST['email']);

        if($_POST['email'] != $_SESSION['oldemail'] && $user){

            $_SESSION['error'] = "Email already in use!";
            unset($_SESSION['oldemail']);
            header("Location: edit.php?id=" . $_POST['id']);
            exit();

        }else{

            unset($_SESSION['oldemail']);
            $_SESSION['email'] = $_POST['email'];
            $_SESSION['name'] = $_POST['name'];
            
            $user = User::find($_POST['id']);

            $user->email = $_POST['email'];
            $user->name = $_POST['name'];

            $stmt = $user->save();

            if($stmt){
                $_SESSION['success'] = "User has been updated successfully!";
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