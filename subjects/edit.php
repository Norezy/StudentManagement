<?php
    require "../database/Database.php";
    require "../models/Subject.php";
    $db = new Database();
    $conn = $db->getConnection();
    Model::setConnection($conn);
?>

<!-- check if user is logged in and if the user is a instructor the user will be sent back to dashboard -->
<?php
    session_start();

    if(!isset($_SESSION['email'])){
        header("Location: ../auth/login.php");
        exit();
    }

    if($_SESSION['role'] == 'instructor'){
        header("Location: ../");
        exit();
    }

    if(!isset($_GET['id'])){
        header("Location: index.php");
        exit();
    }

    $subject = Subject::find($_GET['id']);
    $instructors = User::where('role', '=', 'instructor');
    $courses = Course::all();

    include "../layout/header.php";
    include "../layout/sidebar.php";
?>


<!-- output a sweetalert if success or error -->
<?php

    if(empty($subject)){
        http_response_code(404);
        include "../ErrorCode/404.php";
        exit;
    }

    if(isset($_SESSION['success'])){
        echo '<script> 
            Swal.fire({
                title: "Created!",
                text: "'.$_SESSION['success'].'",
                icon: "success",
                iconColor: "#0b7b55",
                }).then(function() {
                    window.location = "index.php";
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
            <h3 class="fw-bold mb-4" style="color: #061f5c; font-size: 30px; ">EDIT SUBJECT RECORD</h3>
                <form action="update.php" method="POST">
                    <input type="hidden" name="id" value="<?= $subject->id; ?>">
                    
                    <div class = "row">
                        <div class = "col-md-3 mb-3">
                            <label for="code" class="form-label fs-4">Subject Code</label>
                            <input type="text" class="form-control border-0 border-bottom rounded-0 border-black shadow-none fs-5" id="code" name="code" value="<?= $subject->code;?>" readonly>
                        </div>
                        <div class = "col-md-3 mb-3">
                            <label for="catalog-no" class="form-label fs-4">Catalog No.</label>
                            <input type="text" class="form-control border-0 border-bottom rounded-0 border-black shadow-none fs-5" id="catalog-no" name="catalog_no" placeholder="e.g., INTECH 2201" value="<?= $subject->catalog_no; ?>" required>
                        </div>

                        <div class = "col-md-6 mb-3">
                            <label for="subject-name" class="form-label fs-4">Subject Name</label>
                            <input type="text" class="form-control border-0 border-bottom rounded-0 border-black shadow-none fs-5" id="subject-name" name="subject_name" placeholder="Enter Subject Name" value="<?= $subject->name; ?>" required>
                        </div>
                    </div>

                    <div class = "row">
                        <div class = "col-md-2 mb-3">
                            <label for="room" class="form-label fs-4">Room</label>
                            <input type="text" class="form-control border-0 border-bottom rounded-0 border-black shadow-none fs-5" id="room" name="room" placeholder="Enter Room Name" value="<?= $subject->room; ?>" required>
                        </div>

                        <div class = "col-md-2 mb-3">
                            <label for="day" class="form-label fs-4">Day</label>
                            <input type="text" class="form-control border-0 border-bottom rounded-0 border-black shadow-none fs-5" id="day" name="day" placeholder="e.g., T/Th" value="<?= $subject->day; ?>"  required>
                        </div>
        
                        <div class = "col-md-2 mb-3">
                            <label for="time" class="form-label fs-4">Time</label>
                            <input type="text" class="form-control border-0 border-bottom rounded-0 border-black shadow-none fs-5" id="time" name="time" placeholder="HH:ii - HH:Min" value="<?= $subject->time; ?>" required>
                        </div>
                    
                        <div class = "col-md-6 mb-3">
                            <label for="instructor-id" class="form-label fs-4">Instructor</label>
                            <select class="form-select border-0 border-bottom rounded-0 border-black shadow-none fs-5" id="instructor-id" name="instructor_id" required>
                                <option value="" disabled selected>Select an Instructor</option>
                                <?php
                                        foreach($instructors as $instructor){
                                        if($instructor->status == 'active'){
                                            if($instructor->id == $subject->instructor_id){
                                                echo '<option value="'.$instructor->id.'" selected>'.$instructor->name.'</option>';
                                            }else{
                                                echo '<option value="'.$instructor->id.'">'.$instructor->name.'</option>';
                                            }
                                        }
                                        }
                                ?>
                            </select>
                        </div>
                    </div>

                    <div class = "row">
                        <div class = "col-md-8 mb-3">
                            <label for="course-id" class="form-label fs-4">Course</label>
                            <select class="form-select border-0 border-bottom rounded-0 border-black shadow-none fs-5" id="course-id" name="course_id" placeholder="e.g., INTECH 2201" required>
                                <option value=""disabled selected>Select Course</option> 
                                <?php  
                                        foreach($courses as $course){
                                            if($course->id == $subject->course_id){
                                                echo '<option value="'.$course->id.'" selected>'.$course->code.'-'.$course->name.'</option>';
                                            }else{
                                            echo '<option value="'.$course->id.'">'.$course->code.'-'.$course->name.'</option>';
                                        }
                                    }  
                                ?> 
                            </select>
                        </div>
                        

                        <div class = "col-md-2 mb-3">
                            <label for="year-level" class="form-label fs-4">Year Level</label>
                            <select class="form-select border-0 border-bottom rounded-0 border-black shadow-none fs-5" id="year-level" name="year_level" placeholder="e.g., INTECH 2201" required>
                                <option value="" disabled selected>Select Year Level</option>
                                <option value="1" <?= $subject->year_level == 1 ? 'selected' : '' ?>>1st Year</option>
                                <option value="2" <?= $subject->year_level == 2 ? 'selected' : '' ?>>2nd Year</option>
                                <option value="3" <?= $subject->year_level == 3 ? 'selected' : '' ?>>3rd Year</option>
                                <option value="4" <?= $subject->year_level == 4 ? 'selected' : '' ?>>4th Year</option>
                            </select>
                        </div>

                        <div class = "col-md-2 mb-3">
                            <label for="semester" class="form-label fs-4">Semester</label>
                            <select class="form-select border-0 border-bottom rounded-0 border-black shadow-none fs-5" id="semester" name="semester" placeholder="e.g., INTECH 2201" required>
                                <option value="" disabled selected>Select Semester</option>
                                <option value="1" <?= $subject->semester == 1 ? 'selected' : '' ?>>1st Semester</option>
                                <option value="2" <?= $subject->semester == 2 ? 'selected' : '' ?>>2nd Semester</option>
                            </select>
                        </div>
                    </div>

                    <div class = "row" style="width: 250px; margin-left: -2px;">
                            <button type="submit" class="btn fw-bold text-white rounded-5 mt-2" style="background-color: #0b7b55">Update</button>
                            <a href="index.php" class="btn fw-bold btn-secondary mt-2 rounded-5">Cancel</a>
                    </div>

                </form>    
            </div>

        </div>
    </div>


<?php include "../layout/footer.php"; ?>