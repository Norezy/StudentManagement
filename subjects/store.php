<?php
    require "../database/Database.php";
    require "../models/Subject.php"; 
    
        $db = new Database();
        $conn = $db->getConnection();
        Subject::setConnection($conn);

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

        
                $stmt = Subject::create([
                'code' => $_POST['code'],
                'catalog_no' => strtoupper($_POST['catalog_no']),
                'name' => strtoupper($_POST['subject_name']),
                'day' => strtoupper($_POST['day']),
                'time' => $_POST['time'],
                'room' => $_POST['room'],
                'course_id' => $_POST['course_id'],
                'semester' => $_POST['semester'],
                'year_level' => $_POST['year_level'],
                'instructor_id' => $_POST['instructor_id']
                ]);
                        
                if($stmt){
                    $_SESSION['success'] = "Subject Created Successfully!";
                    header("Location: create.php");
                }else{
                    $_SESSION['error'] = "Failed to create Subject, please try again!";
                    header("Location: create.php");
                }

        }else{
            header("Location: create.php");
            exit();
        } 
?>

<div class = "container-xxl bg-white rounded-start-5 " style="max-width: 100%; height: 120vh;">
</div>

<?php include '../layout/footer.php';  ?>