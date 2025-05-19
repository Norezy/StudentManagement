<?php require_once '../Database/Database.php'; 
 $db=new Database();
 $conn = $db->getConnection();
 ?>
<?php include  '../layout/header.php'; ?>
<?php require '../models/Course.php';?>

<?php
    Course::setConnection($conn);
    

    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        $course = Course::find($_POST['id']);
        $stmt = $course->delete();
    
        if($stmt){
    
            echo '<script>window.location = "index.php"</script>';
    
        }else{
                echo '<script>
                        Swal.fire({
                            title: "Error!",
                            text: "Failed to Delete User Record, please try again!",
                            icon: "error",
                            iconColor: "#b91c1c",
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

<?php include  '../layout/footer.php'; ?>