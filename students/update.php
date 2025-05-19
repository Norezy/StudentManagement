<?php 

    require "../database/Database.php";
    require "../models/Student.php";
    include '../layout/header.php';

    $db = new Database();
    $conn = $db->getConnection();
    Student::setConnection($conn);
    
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

    $student = Student::where('student_id', '=', $_POST['student_id']);

    if($student && $_POST['student_id'] != $_SESSION['old_student_id']){
        $_SESSION['error'] = "Student ID already exists!";
        header("Location: edit.php?id=" . $_POST['id']);
        exit();
    }else{
            $student = Student::find($_POST['id']);
            $student->student_id = $_POST['student_id'];
            $student->name = ucwords(strtolower($_POST['name']));
            $student->gender = $_POST['gender'];
            $student->course_id = $_POST['course_id'];
            $student->year_level = $_POST['year_level'];
            $student->birthdate = $_POST['birthdate'];
            $stmt = $student->save();

            if($stmt){
                $_SESSION['success'] = "Student Record Has Been Updated Successfully!";
                header("Location: edit.php?id=" . $_POST['id']);
            }else{
                $_SESSION['error'] = "Failed to Update Student Record, please try again!";
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