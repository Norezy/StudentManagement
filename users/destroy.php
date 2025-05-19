    <?php 
        require "../database/Database.php";
        require "../models/User.php";  
        $db = new Database();
        $conn = $db->getConnection();
        User::setConnection($conn);

        include "../layout/header.php"; 
        session_start();
    ?>

<?php
    //check if the user is logged in and is a super-admin
    if(!isset($_SESSION['email'])){
        header("Location: ../auth/login.php");
        exit();
    }

    if($_SESSION['role'] == 'instructor'){
        header("Location: ../");
        exit();
    }

if($_SERVER['REQUEST_METHOD'] == 'POST'){

    $user = User::find($_POST['id']);
    $stmt = $user->delete();

    if($stmt){

        echo '<script>window.location = "index.php"</script>';

    }else{
            echo '<script>
                    Swal.fire({
                        title: "Error!",
                        text: "Failed to Delete User Record, please try again!",
                        icon: "error",
                        confirmButtonText: "Ok"
                    }).then(function() {
                        window.location = "index.php";
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