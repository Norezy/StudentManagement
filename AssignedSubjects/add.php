<?php
    require "../database/Database.php";
    require "../models/Student.php";
    require "../models/Grade.php";
    $db = new Database();
    $conn = $db->getConnection();
    Model::setConnection($conn);
?>

<!-- check if user is logged in and if the user is a yearlevel the user will be sent back to index.php -->
<?php
    session_start();
    if(!isset($_SESSION['email'])){
        header("Location: ../auth/login.php");
        exit();
    }

    if($_SESSION['role'] != 'instructor'){
        header("Location: ../");
    }
    
    $subject = Subject::find($_GET['subID']);
    $student = Student::find($_GET['studID']);


    if(empty($subject) || empty($student)){
        include "../layout/header.php";
        include "../layout/sidebar.php";
        http_response_code(404);
        include "../ErrorCode/404.php";
        exit;
    }

    $grade = Grade::FindByStudidAndSubid($student->id, $subject->id);
    include "../layout/header.php";
    include "../layout/sidebar.php";
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
                    window.location = "view.php?id='.$_GET['subID'].'";
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
            <h1 class="fw-bold" style="color: #061f5c; font-size: 60px; margin-top: 25px">GRADE MANAGEMENT</h1>
            <h3 class="fw-bold mb-4" style="color: #061f5c; font-size: 30px; ">GRADE STUDENT</h3>
                <form action="store.php" method="POST">
                <?php if($grade != NULL):?>
                <input type="hidden" name="grade_id" value="<?=$grade->id?>">
                <?php endif;?>
                <input type="hidden" name="subject_id" value="<?=$subject->id?>">
                <input type="hidden" name="student_id" value="<?=$student->id?>">

                    <div class = "row">
                        <div class = "col-md-6 mb-3">
                            <label for="catalog-no" class="form-label fs-4">Subject Catalog No</label>
                            <input type="text" class="form-control border-0 border-bottom rounded-0 border-black shadow-none bg-white fs-5" id="catalog-no" name="catalog_no" value="<?=$subject->catalog_no?>" disabled>
                        </div>
                        <div class = "col-md-6 mb-3">
                            <label for="subject-name" class="form-label fs-4">Subject Name</label>
                            <input type="text" class="form-control border-0 border-bottom rounded-0 border-black shadow-none bg-white fs-5"  id="subject-name" name="subject-name" value="<?=$subject->name?>" disabled>
                        </div>
                    </div>
                    <div class = "row">
                        <div class = "col-md-2 mb-3">
                            <label for="student-id" class="form-label fs-4">Student ID</label>
                            <input type="text" class="form-control border-0 border-bottom rounded-0 border-black shadow-none bg-white fs-5" id="student-id" name="student_id" value="<?=$student->student_id ?>"disabled>      
                        </div>
                        <div class = "col-md-6 mb-3">
                            <label for="student-id" class="form-label fs-4">Student</label>
                            <input type="text" class="form-control border-0 border-bottom rounded-0 border-black shadow-none bg-white fs-5" id="student-id" name="student_id" value="<?=$student->name?>" disabled>      
                        </div>
                    </div>
                    <div class = "row">
                        <div class = "col-md-4 mb-3">
                            <label for="Grade" class="form-label fs-4">Grade</label>
                            <select class="form-select border-0 border-bottom rounded-0 border-black shadow-none fs-5" id="Grade" name="Grade" required>
                            <?php if($grade->grade == NULL):?>
                                <option value="" selected disabled>Select Remarks</option>
                                <option value="1.0">1.0</option>
                                <option value="1.25">1.25</option>
                                <option value="1.5">1.5</option>
                                <option value="1.75">1.75</option>
                                <option value="2.0">2.0</option>
                                <option value="2.25">2.25</option>
                                <option value="2.5">2.5</option>
                                <option value="2.75">2.75</option>
                                <option value="3.0">3.0</option>
                                <option value="5.0">5.0</option>
                                <option value="">N/A</option>
                            <?php else:?>
                                <option value="1.0" <?= $grade->grade == 1.0 ? "selected" : NULL ?>>1.0</option>
                                <option value="1.25" <?= $grade->grade == 1.25 ? "selected" : NULL ?>>1.25</option>
                                <option value="1.5" <?= $grade->grade == 1.5 ? "selected" : NULL ?>>1.5</option>
                                <option value="1.75" <?= $grade->grade == 1.75 ? "selected" : NULL ?>>1.75</option>
                                <option value="2.0" <?= $grade->grade == 2.0 ? "selected" : NULL ?>>2.0</option>
                                <option value="2.25" <?= $grade->grade == 2.25 ? "selected" : NULL ?>>2.25</option>
                                <option value="2.5" <?= $grade->grade == 2.5 ? "selected" : NULL ?>>2.5</option>
                                <option value="2.75" <?= $grade->grade == 2.75 ? "selected" : NULL ?>>2.75</option>
                                <option value="3.0" <?= $grade->grade == 3.0 ? "selected" : NULL ?>>3.0</option>
                                <option value="5.0" <?= $grade->grade == 5.0 ? "selected" : NULL ?>>5.0</option>
                                <option value="">N/A</option>
                            <?php endif;?>
                            </select>
                        </div>
                    </div>

                    <div class = "row" style="width: 250px; margin-left: -2px;">
                        
                            <button type="submit" class="btn fw-bold text-white rounded-5 mt-2" style="background-color: #0b7b55"><?= $grade ? 'UPDATE GRADE' : 'ADD GRADE'?> </button>
                            <a href="view.php?id=<?=$subject->id?>" class="btn fw-bold btn-secondary mt-2 rounded-5">Cancel</a>
                    </div>

                </form>    
            </div>

        </div>
    </div>


<?php include "../layout/footer.php"; ?>