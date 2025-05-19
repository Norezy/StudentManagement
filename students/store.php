<?php
    require "../database/Database.php";
    require "../models/Student.php"; 
    
        $db = new Database();
        $conn = $db->getConnection();
        Student::setConnection($conn);

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

        $check = Student::where('student_id', '=', $_POST['student_id']);
        if($check){
            $_SESSION['error'] = "Student ID already exists!";
            header("Location: create.php");
            exit();
        }else{
                $stmt = Student::create([

                    'student_id' => $_POST['student_id'],
                    'name' => ucwords(strtolower($_POST['name'])),
                    'gender' => $_POST['gender'],
                    'status' => $_POST['status'],
                    'course_id' => $_POST['course_id'],
                    'year_level' => $_POST['year_level'],
                    'birthdate' => $_POST['birthdate'],
                ]);
                        
                if($stmt){
                    $_SESSION['success'] = "Student Record Created Successfully!";
                    header("Location: create.php");
                }else{
                    $_SESSION['error'] = "Failed to create Student Record, please try again!";
                    header("Location: create.php");
                }
        }

    }else{
        header("Location: create.php");
        exit();
    } 
?>

<div class = "container-xxl bg-white rounded-start-5 " style="max-width: 100%; height: 120vh;">
</div>

<?php include '../layout/footer.php';  ?>