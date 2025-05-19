<?php
    require "../database/Database.php";
    require "../models/Course.php"; 
    
        $db = new Database();
        $conn = $db->getConnection();
        Course::setConnection($conn);

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
        $Course = Course::where('name','=', strtoupper($_POST['name']));
        if($Course){
            $_SESSION['error'] = "Course Name already in use!";
            header("Location: create.php");
            exit();
        }

        $Course = Course::where('code','=',$_POST['code']);

        if($Course){
            $_SESSION['error'] = "Course Code already in use!";
            header("Location: create.php");
            exit();
        }else{
            $stmt = Course::create([
            'code' => strtoupper($_POST['code']),
            'name' => strtoupper($_POST['name'])
            ]);
                    
            if($stmt){
            //para may success message at value sa create.php pag nag success
                $_SESSION['success'] = "Course Has Been Created Successfully!";
                header("Location: create.php");
            }else{
                $_SESSION['error'] = "Failed to Create Course, please try again!";
                header("Location: create.php");
            }
        }  
    }else{
        header("Location: index.php");
        exit();
    }
?>

<div class = "container-xxl bg-white rounded-start-5 " style="max-width: 100%; height: 120vh;">
</div>

<?php include '../layout/footer.php';  ?>