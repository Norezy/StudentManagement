<?php 

    require "../database/Database.php";
    require "../models/Course.php";
    include '../layout/header.php';

    $db = new Database();
    $conn = $db->getConnection();
    Course::setConnection($conn);
    
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

        $coursename = Course::where('name','=', strtoupper($_POST['name']));

        if($coursename && strtoupper($_POST['name']) != $_SESSION['coursename']){
            $_SESSION['error'] = "Course Name already in use!";
            header("Location: edit.php?id=" . $_POST['id']);
            exit();
        }

        $coursecode = Course::findByCode($_POST['code']);

        if(strtoupper($_POST['code']) != $_SESSION['coursecode'] && $coursecode){

            $_SESSION['error'] = "Code already in use!";
            
            header("Location: edit.php?id=" . $_POST['id']);
            unset($_SESSION['coursecode']);
            exit();

        }else{

            $course = Course::find($_POST['id']);

            unset($_SESSION['coursecode']);

            $course->code = strtoupper($_POST['code']);
            $course->name = strtoupper($_POST['name']);
            $stmt = $course->save();

            if($stmt){
                $_SESSION['success'] = "Course Has Been Updated Successfully!";
                header("Location: edit.php?id=" . $_POST['id']);
            }else{
                $_SESSION['error'] = "Failed to update Course, please try again!";
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