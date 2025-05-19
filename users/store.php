<?php
    require "../database/Database.php";
    require "../models/User.php"; 
    
        $db = new Database();
        $conn = $db->getConnection();
        User::setConnection($conn);

    session_start();
    include '../layout/header.php';


    //check if the user is logged in and is a instructor

        if(!isset($_SESSION['email'])){
        header("Location: ../auth/login.php");
        exit();
        }

        if($_SESSION['role'] == 'instructor'){
            header("Location: ../");
            exit();
        }

    

    //check if the form is submitted as a POST request
    if($_SERVER['REQUEST_METHOD'] == 'POST'){

    //check if the email is already in use   
        
        $user = User::findByEmail($_POST['email']);
        if($user){
            $_SESSION['error'] = "Email already in use!";
            header("Location: create.php");
            exit();
            
        }    

         
        //check if the password and confirm password are the same

        if($_POST['password'] != $_POST['cpassword']){
            $_SESSION['error'] = "Passwords do not match!";
            header("Location: create.php");
            exit();
        }else{
                   
                $stmt = User::create([
                'email' => strtolower($_POST['email']),
                'name' =>  ucwords(strtolower($_POST['name'])),
                'role' => $_POST['role'], 
                'status' => $_POST['status'], 
                'password' => password_hash($_POST['password'], PASSWORD_DEFAULT)
                ]);
                        
                if($stmt){
                //para may success message at value sa create.php pag nag success
                    $_SESSION['success'] = "User Created Successfully!";
                    header("Location: create.php");
                }else{
                    $_SESSION['error'] = "Failed to create User, please try again!";
                    header("Location: create.php");
                }

        }

    }else{
        header("Location: index.php");
    }   
?>

<div class = "container-xxl bg-white rounded-start-5 " style="max-width: 100%; height: 120vh;">
</div>

<?php include '../layout/footer.php';  ?>