<?php 
    require "database/Database.php"; 
    require_once "models/User.php";
    require_once "models/Student.php";
    require_once "models/Course.php";
    require_once "models/subject.php";
    require_once "models/Subject_Enrollment.php";
    require_once "models/Grade.php";

    $db = new Database();
    $conn = $db->getConnection();
    Model::setConnection($conn);
?>

<?php
    session_start();
    
    if(!isset($_SESSION["email"])){
        header("Location: auth/login.php");
    }

    $users = User::all();
    $student = Student::all();
    $course = Course::all();
    $subject = Subject::all();
    $instructor = 0;
    $admin = 0;

    foreach($users as $user){
        if($user -> role == 'instructor'){
            $instructor++;
        }elseif($user -> role == 'admin'){
            $admin++;
        }
    }

    if($course == null){
        $course = 0;
    }else{
        $course = count($course);
    }

    if($student == null){
        $student = 0;
    }else{
        $student = count($student);
    }

    if($subject == null){
        $subject = 0;
    }else{
        $subject = count($subject);
    }


    $EnrolledStudentInstructor = 0;
    $graded = 0;
    $notgraded = 0;

    if($_SESSION['role'] == 'instructor'){
        $subjects = Subject::where('instructor_id','=', $_SESSION['userID']);

    if($subjects !== null){ 
        foreach($subjects as $subject) { 
            foreach($subject->students() as $student){
                if($student->status == 'active'){
                    $EnrolledStudentInstructor++;
                }     
            }
        }

        foreach($subjects as $subject) {
                foreach($subject->students() as $student) {
                    if($student->status == 'active'){
                        if(Grade::getGrades($student->id, $subject->id) != null) {
                            $graded++;
                        } else {
                            $notgraded++;
                        }

                    }
                }
            }
        }
    }


?>
        
    <?php    
    include "layout/header.php";
    include "layout/sidebar.php";
?>

<div class = "container-xxl bg-white rounded-start-5 main-content" style="max-width: 100%; min-height: 130vh; max-height: auto; padding-right: 90px; padding-left: 75px; padding-top: 20px; ">


<?php if($_SESSION['role'] !== 'instructor'):?>

    <h1 class = "text-left fw-bold pt-5 ps-5" style="color: #061f5c; font-size: 60px;">DASHBOARD</h1>
        <div class="d-flex flex-row justify-content-center mb-3 pt-4 ps-5" style="text-align: center;">

            <div class="card-body text-white rounded-5 me-5" style="background-color: #15803d; min-height: 30vh; max-height: auto; max-width: 600px;">
                <div>
                    <h1 class="fw-bold" style="font-size: 150px;"><?= $student ?></h1>
                    <hr class="mx-auto" style="width: 200px; height: 2px; background-color: white;">
                    <h2>Total Number of Students</h2>
                </div>
            </div>

            <div class="card-body text-white rounded-5 me-5" style="background-color: #15803d; min-height: 30vh; max-height: auto; max-width: 600px;">
                <div>
                    <h1 class="fw-bold" style="font-size: 150px;"><?= $course ?></h1>
                    <hr class="mx-auto" style="width: 200px; height: 2px; background-color: white;">
                    <h2>Total Number of Courses</h2>
                </div>
            </div>
        
        <?php if($_SESSION['role'] == 'super-admin'):?>

            <div class="card-body text-white rounded-5 me-5" style="background-color: #15803d; min-height: 30vh; max-height: auto; max-width: 600px;">
                <div>
                    <h1 class="fw-bold" style="font-size: 150px;"><?= $subject ?></h1>
                    <hr class="mx-auto" style="width: 200px; height: 2px; background-color: white;">
                    <h2>Total Number of Subjects</h2>
                </div>
            </div>

        <?php endif;?>

    </div><!--end of d-flex-->

    <div class="d-flex flex-row justify-content-center mb-3 pt-4 ps-5" style="text-align: center;">

        <?php if($_SESSION['role'] == 'super-admin'):?>

            <div class="card-body text-white rounded-5 me-5" style="background-color: #15803d; min-height: 30vh; max-height: auto; max-width: 500px;">
                <div>
                    <h1 class="fw-bold" style="font-size: 150px;"><?= $instructor?></h1>
                    <hr class="mx-auto" style="width: 200px; height: 2px; background-color: white;">
                    <h2>Total Number of Instructor</h2>
                </div>
            </div>
            
            <div class="card-body text-white rounded-5 me-5" style="background-color: #15803d; min-height: 30vh; max-height: auto; max-width: 500px;">
                <div>
                    <h1 class="fw-bold" style="font-size: 150px;"><?= $admin?></h1>
                    <hr class="mx-auto" style="width: 200px; height: 2px; background-color: white;">
                    <h2>Total Number of Admin</h2>
                </div>
            </div>

        <?php else: ?>

            <div class="card-body text-white rounded-5 me-5" style="background-color: #15803d; min-height: 30vh; max-height: auto; max-width: 600px;">
                <div>
                    <h1 class="fw-bold" style="font-size: 150px;"><?= $instructor?></h1>
                    <hr class="mx-auto" style="width: 200px; height: 2px; background-color: white;">
                    <h2>Total Number of Instructor</h2>
                </div>
            </div>

            <div class="card-body text-white rounded-5 me-5" style="background-color: #15803d; min-height: 30vh; max-height: auto; max-width: 600px;">
                <div>
                    <h1 class="fw-bold" style="font-size: 150px;"><?= $subject ?></h1>
                    <hr class="mx-auto" style="width: 200px; height: 2px; background-color: white;">
                    <h2>Total Number of Subjects</h2>
                </div>
            </div>

        <?php endif;?>

    </div><!--end of d-flex-->
<?php else: ?>

<div class="card border-0 text-center d-flex justify-content-evenly" style="margin-left: 50px;"> 
        <h1 class = "text-left fw-bold pt-5 d-flex align-items-left" style="color: #061f5c; font-size: 60px; margin-left: 20px;">DASHBOARD</h1>
    <div class = "card-body">
        <div class = "row">
                <div class = "col" style = "margin-left: 0px; max-width: 600px;">

                    <div class="card-body text-white rounded-5 mb-3" style="background-color: #15803d; min-height: 30vh; max-height: auto; max-width: 500px;">
                        <div>
                            <h1 class="fw-bold" style="font-size: 150px;"><?php if($EnrolledStudentInstructor<10){echo '0';} echo $EnrolledStudentInstructor; ?></h1>
                            <hr class="mx-auto" style="width: 200px; min-height: 2px; background-color: white;">
                            <h2>Total Number of Enrolled Student</h2>
                        </div>
                    </div>

                    <div class="card-body text-white rounded-5" style="background-color: #15803d; min-height: 45vh; max-height: auto; max-width: 500px;">
                        <h1 class="fw-bold fs-3 pt-3">Pending Grading Task</h1>
                        <hr class="mx-auto" style="width: 400px; height: 2px; background-color: white;">
                        <div id="chart" class="ps-5">
                        </div>
                        <script>
                            var options = {
                            series: [<?=$graded?>, <?=$notgraded?>],
                            chart: {
                            width: 380,
                            type: 'pie',
                            },
                            colors:['#334eac', '#940909'],
                            labels: ['Graded', 'Not Graded'],
                            responsive: [{
                            breakpoint: 480,
                            options: {
                                chart: {
                                width: 200
                                }
                            }
                            }],
                            legend: {
                                labels: {
                                    colors: ['#ffffff','#ffffff'] // Set label text color to white
                                }
                            },
                            stroke: {
                                colors: ['#15803d'] // Set border color to black
                            }
                            };

                            var chart = new ApexCharts(document.querySelector("#chart"), options);
                            chart.render();
                        </script>
                    </div> 
                </div>
                            
                <div class = "col">
                    <div class="card-body text-white rounded-5" style="background-color: #15803d; min-height: 102.3vh; max-height: auto; max-width: 500px;">
                        <h1 class="fw-bold text-center" style="font-size: 40px;">Assigned Subjects</h1>
                        <hr class="mx-auto" style="width: 600px; height: 2px; background-color: white;">
                        <?php if($subjects !== null):?>
                            <?php foreach($subjects as $subject):?>
                                    <div>
                                        <div class="text-start" style="margin-left: 50px;">
                                        <h1 style="font-size: 18px;" >
                                        <?="<strong>Course: </strong>" . $subject->course()->name . ' - '?>
                                        <?php switch($subject -> year_level){
                                            case 1:
                                                echo "1st Year";
                                                break;
                                            case 2:
                                                echo "2nd Year";
                                                break;
                                            case 3:
                                                echo "3rd Year";
                                                break;
                                            case 4:
                                                echo "4th Year";
                                                break;
                                            default:
                                                echo "N/A";
                                            } ?></h1>
                                            <h1 style="font-size: 18px;">
                                            <?= "<strong>Subject: </strong>" . $subject->catalog_no . ' - ' . $subject->name?></h1>
                                        </div>
                                        <hr class="mx-auto" style="width: 600px; height: 2px; background-color: white;">
                                    </div>
                            <?php endforeach; ?>
                        <?php endif;?>
                    </div>
                </div>
        </div>
    </div>
         
</div>
<?php endif;    ?>

</div><!--end of container-->   
       
<?php include 'layout/footer.php';  ?>
    