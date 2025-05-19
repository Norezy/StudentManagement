<?php
    require "../../database/Database.php";
    require "../../models/Subject_Enrollment.php"; 
    require_once "../../models/Grade.php";
        $db = new Database();
        $conn = $db->getConnection();
        Subject_Enrollment::setConnection($conn);

    session_start();
    include '../../layout/header.php';


    //check if the user is logged in and is a instructor

        if(!isset($_SESSION['email'])){
        header("Location: ../../auth/login.php");
        exit();
        }

        if($_SESSION['role'] == 'instructor'){
            header("Location: ../../");
            exit();
        }

        $enrolled = Subject_Enrollment::findSubject_EnrollmentByStudIDandSubID($_POST['student_id'], $_POST['subject_id']);
        if($enrolled){
            $_SESSION['error'] = "Student Already Enrolled!";
            header("Location: enroll.php?id=".$_POST['subject_id']);
            exit();
        }
        
    //check if the form is submitted as a POST request
    if($_SERVER['REQUEST_METHOD'] == 'POST'){

        
                $stmt = Subject_Enrollment::create([
                'subject_id' => $_POST['subject_id'],
                'student_id' => $_POST['student_id'],
                'status' => $_POST['status'],
                ]);
                        
                if($stmt){
                    $_SESSION['success'] = "Student enrolled Successfully!";
                    header("Location: enroll.php?id=".$_POST['subject_id']);
                }else{
                    $_SESSION['error'] = "Failed to enroll student, please try again!";
                    header("Location: enroll.php?id=".$_POST['subject_id']);
                }

        }else{
            header("Location: enroll.php?=id=".$_POST['subject_id']);
            exit();
        } 
?>

<div class = "container-xxl bg-white rounded-start-5 " style="max-width: 100%; height: 120vh;">
</div>

<?php include '../../layout/footer.php';  ?>