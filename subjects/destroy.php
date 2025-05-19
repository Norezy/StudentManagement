    <?php 
        require "../database/Database.php";
        require "../models/Subject.php";  
        $db = new Database();
        $conn = $db->getConnection();
        Subject::setConnection($conn);

        include "../layout/header.php"; 
        session_start();
    ?>

<?php
    //check if the subject is logged in and is a super-admin
    if(!isset($_SESSION['email'])){
        header("Location: ../auth/login.php");
        exit();
    }

    if($_SESSION['role'] == 'instructor'){
        header("Location: ../");
        exit();
    }

if($_SERVER['REQUEST_METHOD'] == 'POST'){

    $subject = Subject::find($_POST['id']);
    $stmt = $subject->delete();

    if($stmt){

        header("Location: index.php");

    }else{
            echo '<script>
                    Swal.fire({
                        title: "Error!",
                        text: "Failed to Delete Subject Record, please try again!",
                        icon: "error",
                        iconColor: "#b91c1c",
                        confirmButtonText: "Ok"
                    }).then(function() {
                        window.location = "index.php" ;
                    });
                </script>';
    }
}else{
    header("Location: index.php");
    exit();
}


?>
<div class = "container-xxl bg-white rounded-start-5 " style="max-width: 100%; height: 120vh;">
</div>



<?php include "../layout/footer.php"; ?>