<?php
    require "../database/Database.php";
    require "../models/grade.php"; 

        $db = new Database();
        $conn = $db->getConnection();
        Model::setConnection($conn);

    session_start();
    include '../layout/header.php';


    //check if the user is logged in and is a instructor

        if(!isset($_SESSION['email'])){
        header("Location: ../auth/login.php");
        exit();
        }

        if($_SESSION['role'] != 'instructor'){
            header("Location: ../");
            exit();
        }

    //check if the form is submitted as a POST request
    if($_SERVER['REQUEST_METHOD'] == 'POST'){


        if($_POST['Grade'] <= 3.0 && $_POST['Grade'] >= 1.0){
            $remarks = "passed";
        }elseif($_POST['Grade'] == 5.0){
            $remarks = "failed";
        }else{
            $remarks = "incomplete";
        }

        if(isset($_POST['grade_id'])){
                $grade = Grade::find($_POST['grade_id']);
                $stmt = $grade->Update([
                "student_id" => $_POST['student_id'],
                "subject_id" => $_POST['subject_id'],
                "instructor_id" => $_SESSION['userID'],
                "grade" => isset($_POST['Grade']) && $_POST['Grade'] !== '' ? $_POST['Grade'] : null,
                "remarks" => $remarks,
                ]);
                        
                if($stmt){
                    $_SESSION['success'] = "Grade Submitted Successfully!";
                    header("Location: add.php?studID=" . $_POST['student_id'] . "&subID=".$_POST['subject_id']);
                }else{
                    $_SESSION['error'] = "Failed to submit Grade, please try again!";
                    header("Location: add.php?studID=" . $_POST['student_id'] . "&subID=".$_POST['subject_id']);
                }
            }else{
                $stmt = Grade::Create([
                    "student_id" => $_POST['student_id'],
                    "subject_id" => $_POST['subject_id'],
                    "instructor_id" => $_SESSION['userID'],
                    "grade" => $_POST['Grade'],
                    "remarks" => $remarks,
                ]);
                
                if($stmt){
                    $_SESSION['success'] = "Grade Submitted Successfully!";
                    header("Location: add.php?studID=" . $_POST['student_id'] . "&subID=".$_POST['subject_id']);
                    exit();
                }else{
                    $_SESSION['error'] = "Failed to submit Grade, please try again!";
                    header("Location: add.php?studID=" . $_POST['student_id'] . "&subID=".$_POST['subject_id']);
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