<?php 

    require "../../database/Database.php";
    include '../../layout/header.php';
    require "../../models/Subject_Enrollment.php"; 
    
    $db = new Database();
    $conn = $db->getConnection();
    Subject_Enrollment::setConnection($conn);
    
    session_start();
    

?>


<!-- check if user is logged in and if the user is a instructor the user will be sent back to index.php -->
<?php

    if(!isset($_SESSION['email'])){
        header("Location: ../../auth/login.php");
        exit();
    }

    if($_SESSION['role'] == 'intructor'){
        header("Location: ../../");
    }

?>



<?php

if($_SERVER['REQUEST_METHOD'] == 'POST'){

    
            $subject = Subject_Enrollment::find($_POST['id']);
            
            $subject->status = $_POST['status'];

            $stmt = $subject->save();

            if($stmt){
                $_SESSION['success'] = "Student Status Updated Successfully!";
                header("Location: edit.php?studID=" . $_POST['student_id']. "&subID=" . $_POST['subject_id']);
            }else{
                $_SESSION['error'] = "Failed to Update Student Status, please try again!";
                header("Location: edit.php?id=" . $_POST['id']);
            }

}else{
        header("Location: index.php");
}

?>


<div class = "container-xxl bg-white rounded-start-5 " style="max-width: 100%; height: 120vh;">
</div>

<?php include '../../layout/footer.php';  ?>