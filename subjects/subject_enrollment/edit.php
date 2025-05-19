<?php
    require "../../database/Database.php";
    require "../../models/Subject_Enrollment.php";
    require "../../models/Subject.php";
    $db = new Database();
    $conn = $db->getConnection();
    Model::setConnection($conn);
?>

<!-- check if user is logged in and if the user is a yearlevel the user will be sent back to index.php -->
<?php
    session_start();
    if(!isset($_SESSION['email'])){
        header("Location: ../../auth/login.php");
        exit();
    }

    if($_SESSION['role'] == 'instructor'){
        header("Location: ../../");
    }

    if(!isset($_GET['subID']) || !isset($_GET['studID'])){
        header("Location: ../");
        exit();
    }
    
    $subject = Subject::find($_GET['subID']);
    $student = Student::find($_GET['studID']);
    $subEnroll = Subject_Enrollment::findByStudentID($_GET['studID']);

    include "../../layout/header.php";
    include "../../layout/sidebar.php";
?>


<!-- output a sweetalert if success or error -->
<?php
    if(isset($_SESSION['success'])){
        echo '<script> 
            Swal.fire({
                title: "Created!",
                text: "'.$_SESSION['success'].'",
                icon: "success",
                iconColor: "#0b7b55",
                }).then(function() {
                    window.location = "../view.php?id='.$_GET['subID'].'";
            });
        </script>';
    }
    unset($_SESSION['success']);

    if(isset($_SESSION['error'])){
        echo '<script>
            Swal.fire({
                title: "Error!",
                html: "'.$_SESSION['error'].'",
                icon: "error",
                iconColor: "#b91c1c",
            });
        </script>';
    }
    unset($_SESSION['error']); 
?>
<!-- end of sweetalert -->


    <div class = "container-xxl bg-white rounded-start-5 p-5" style="max-width: 100%; height: 120vh;">

        <div class="card mx-auto border-0" style="width:80%; height: 100%;">
        

            <div class="card-body">
            <h1 class="fw-bold" style="color: #061f5c; font-size: 60px; margin-top: 25px">SUBJECT MANAGEMENT</h1>
            <h3 class="fw-bold mb-4" style="color: #061f5c; font-size: 30px; ">ENROLL STUDENT</h3>
                <form action="update.php" method="POST">

                <input type="hidden" name="id" value="<?=$subEnroll->id?>">
                <input type="hidden" name="subject_id" value="<?=$subject->id?>">
                <input type="hidden" name="student_id" value="<?=$student->id?>">

                    <div class = "row">
                        <div class = "col-md-4 mb-3">
                            <label for="catalog-no" class="form-label fs-4">Subject Catalog No</label>
                            <input type="text" class="form-control border-0 border-bottom rounded-0 border-black shadow-none bg-white fs-5" id="catalog-no" name="catalog_no" value="<?=$subject->catalog_no?>" disabled>
                        </div>
                        <div class = "col-md-6 mb-3">
                            <label for="subject-name" class="form-label fs-4">Subject Name</label>
                            <input type="text" class="form-control border-0 border-bottom rounded-0 border-black shadow-none bg-white fs-5"  id="subject-name" name="subject-name" value="<?=$subject->name?>" disabled>
                        </div>
                    </div>
                    <div class = "row">
                    <div class = "col-md-8 mb-3">
                            <label for="student-id" class="form-label fs-4">Student</label>
                            <input type="text" class="form-control border-0 border-bottom rounded-0 border-black shadow-none bg-white fs-5" id="student-id" name="student_id" value="<?=$student->student_id ?>-<?=$student->name?>" disabled>      
                        </div>
                    </div>
                    <div class = "row">
                        <div class = "col-md-4 mb-3">
                            <label for="status" class="form-label fs-4">Status</label>
                            <select class="form-select border-0 border-bottom rounded-0 border-black shadow-none fs-5" id="status" name="status" required>
                                <option value="enrolled" <?= $subEnroll -> status == 'enrolled' ? 'selected' : NULL ?> >Enrolled</option>
                                <option value="dropped" <?= $subEnroll -> status == 'dropped' ? 'selected' : NULL ?> >Dropped</option>
                                <option value="completed" <?= $subEnroll -> status == 'completed' ? 'selected' : NULL ?> >Completed</option>
                            </select>
                        </div>
                    </div>

                    <div class = "row" style="width: 250px; margin-left: -2px;">
                            <button type="submit" class="btn fw-bold text-white rounded-5 mt-2" style="background-color: #0b7b55">Update</button>
                            <a href="../view.php?id=<?=$subject->id?>" class="btn fw-bold btn-secondary mt-2 rounded-5">Cancel</a>
                    </div>

                </form>    
            </div>

        </div>
    </div>


<?php include "../../layout/footer.php"; ?>