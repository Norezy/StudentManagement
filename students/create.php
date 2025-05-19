<?php
    require "../database/Database.php";
    require "../models/Student.php";

    $db = new Database();
    $conn = $db->getConnection();
    Student::setConnection($conn);
?>

<!-- check if user is logged in and if the user is a instructor the user will be sent back to index.php -->
<?php
    session_start();
    if(!isset($_SESSION['email'])){
        header("Location: ../auth/login.php");
        exit();
    }

    if($_SESSION['role'] == 'instructor'){
        header("Location: ../");
    }

    $courses = Course::all();

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
            <h1 class="fw-bold" style="color: #061f5c; font-size: 60px; margin-top: 25px">STUDENT MANAGEMENT</h1>
            <h3 class="fw-bold mb-4" style="color: #061f5c; font-size: 30px; ">CREATE STUDENT RECORD</h3>
            <form action="store.php" method="POST">
                <div class = "row">
                        <div class = "col-md-6 mb-3">
                            <label for="student-id"  class="form-label fs-4">Student ID</label>
                            <input type="text" id="student-id" name="student_id" class="form-control border-0 border-bottom rounded-0 border-black shadow-none fs-5" placeholder='e.g., 23-1234' required>
                        </div>

                        <div class = "col-md-6 mb-3">
                            <label for="name" class="form-label fs-4">Full Name</label>
                            <input type="text" id="name" name="name" class="form-control border-0 border-bottom rounded-0 border-black shadow-none fs-5" placeholder='e.g., Juan Dela Cruz' required>
                        </div>
                    </div>

                    <div class = "row">
                        <div class = "col-md-4 mb-3">
                        <label for="gender" class="form-label fs-4">Gender</label>
                            <select class="form-select border-0 border-bottom rounded-0 border-black shadow-none fs-5" id="gender" name="gender" required>
                                <option value="" disabled selected>Select Gender</option>
                                <option value="male">Male</option>
                                <option value="female">Female</option>
                            </select> 
                        </div>
        
                        <div class = "col-md-4 mb-3">
                            <label for="birthdate" class="form-label fs-4">Date of birth</label>
                            <input type="date" class="form-control border-0 border-bottom rounded-0 border-black shadow-none fs-5" id="birthdate" name="birthdate" required>
                        </div>
                    
                        <div class = "col-md-4 mb-3">
                            <label for="status" class="form-label fs-4">Status</label>
                                <select class="form-select border-0 border-bottom rounded-0 border-black shadow-none fs-5" id="status" name="status" required>
                                    <option value="" disabled selected>Select Status</option>
                                    <option value="active">Active</option>
                                    <option value="inactive">Inactive</option>
                                </select>
                            </select>
                        </div>
                    </div>

                    <div class = "row">
                        <div class = "col-md-4 mb-3">
                            <label for="course-id" class="form-label fs-4">Course</label>
                            <select class="form-select border-0 border-bottom rounded-0 border-black shadow-none fs-5" id="course-id" name="course_id" placeholder="e.g., INTECH 2201" required>
                                <option value=""disabled selected>Select Course</option> 
                                <?php  
                                        foreach($courses as $course){
                                            echo '<option value="'.$course->id.'">'.$course->code.' - '.$course->name.'</option>';
                                        }  
                                ?> 
                            </select>
                        </div>
                        

                        <div class = "col-md-4 mb-3">
                            <label for="year-level" class="form-label fs-4">Year Level</label>
                            <select class="form-select border-0 border-bottom rounded-0 border-black shadow-none fs-5" id="year-level" name="year_level" placeholder="e.g., INTECH 2201" required>
                                <option value="" disabled selected>Select Year Level</option>
                                <option value="1">1st Year</option>
                                <option value="2">2nd Year</option>
                                <option value="3">3rd Year</option>
                                <option value="4">4th Year</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class = "row" style="width: 250px; margin-left: -2px;">
                            <button type="submit" class="btn fw-bold text-white rounded-5 mt-2" style="background-color: #0b7b55">Create</button>
                            <a href="index.php" class="btn fw-bold btn-secondary mt-2 rounded-5">Cancel</a>
                    </div>
                </form> 
            </div>

        </div>
    </div>


<?php include "../layout/footer.php"; ?>