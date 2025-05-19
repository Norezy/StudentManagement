<?php 

    require "../database/Database.php";
    require "../models/Subject.php";
    include '../layout/header.php';

    $db = new Database();
    $conn = $db->getConnection();
    Subject::setConnection($conn);
    
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
        exit();
    }

?>



<?php

if($_SERVER['REQUEST_METHOD'] == 'POST'){

    
            $subject = Subject::find($_POST['id']);
            $subject->catalog_no = strtoupper($_POST['catalog_no']);
            $subject->name = strtoupper($_POST['subject_name']);
            $subject->day = strtoupper($_POST['day']);
            $subject->time = $_POST['time'];
            $subject->room = $_POST['room'];
            $subject->course_id = $_POST['course_id'];
            $subject->semester = $_POST['semester'];
            $subject->year_level = $_POST['year_level'];
            $subject->instructor_id = $_POST['instructor_id'];
            $stmt = $subject->save();

            if($stmt){
                $_SESSION['success'] = "Subject Has Been Updated Successfully!";
                header("Location: edit.php?id=" . $_POST['id']);
            }else{
                $_SESSION['error'] = "Failed to update Subject, please try again!";
                header("Location: edit.php?id=" . $_POST['id']);
            }

}else{
        header("Location: index.php");
}

?>


<div class = "container-xxl bg-white rounded-start-5 " style="max-width: 100%; height: 120vh;">
</div>

<?php include '../layout/footer.php';  ?>