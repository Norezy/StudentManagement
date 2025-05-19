<?php 
    require "../database/Database.php"; 
    require "../models/course.php";

    $db = new Database();
    $conn = $db->getConnection();
    Course::setConnection($conn);
    
    session_start();
?>

<?php
    if(!isset($_SESSION['email'])){
        header("Location: ../auth/login.php");
        exit();
    }

    if($_SESSION['role'] == 'instructor'){
        header("Location: ../");
    }

    if(!isset($_GET['id'])){
        header("Location: index.php");
        exit();
    }

    $course = Course::find($_GET['id']);
    
    
?>

<?php
    include '../layout/header.php';
    include '../layout/sidebar.php';
    if(empty($course)){
        http_response_code(404);
        include "../ErrorCode/404.php";
        exit;
    }
?>


    <div class = "container-xxl bg-white rounded-start-5 main-content pb-3" style="max-width: 100%; height: auto;padding-right: 75px; padding-left: 125px; padding-top: 75px; min-height: 120vh;">

        <h1 class="fw-bold" style="color: #061f5c; font-size: 60px; margin-left: 15px;">COURSE MANAGEMENT</h1>
        <h2 class="fw-semibold mb-3" style="color: #061f5c; font-size: 40px; margin-left: 15px;">COURSE RECORD</h1>
        
        <div class = "card mx-auto w-100 mb-2 border-0">
            <div class = "card-body w-100">
                <div class ="d-flex justify-content-start mb-2">
                    <div class = "border-1 border-secondary fw-bold" style="color: #061f5c; font-size: 35px;"><?= $course -> name ?> (<?= $course -> code ?>)</div>
                </div>

                            
            </div>
        </div>  
                <div class="card border-0 ms-3">
                    <table id= "CourseTable" class = "table">
                        <thead class = "text-white">
                            <tr>
                                <th class = "text-center text-white p-4">#</th>
                                <th class = "text-center text-white p-4">Student ID</th>
                                <th class = "text-center text-white p-4">Name</th>
                                <th class = "text-center text-white p-4">Gender</th>
                                <th class = "text-center text-white p-4">Year Level</th>
                            </tr>
                        </thead>
                        <tbody> 
                            <?php if($course->students() != null): ?>
                                <?php $id=1; foreach($course->students() as $student):?>
                                    <?php if($student->status == 'active'): ?>
                                        <tr>
                                            <td class = "text-center border-1 border-secondary"><?=$id++?></td>
                                            <td class = "text-center border-1 border-secondary"><?=$student->student_id?></td>
                                            <td class = "text-center border-1 border-secondary"><?=$student->name?></td>
                                            <td class = "text-center border-1 border-secondary"><?=ucfirst($student->gender)?></td>
                                            <td class = "text-center border-1 border-secondary">
                                            <?php switch($student->year_level){
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
                                            }?></td>
                                        </tr>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody> 
                    </table> 
                    <div class = "row" style="width: 250px; margin-left: -2px;">
                            <button onclick="ViewCourseReport(<?= $course->id ?>)" class="btn fw-bold text-white rounded-5 mt-2" style="background-color: #0b7b55">GENERATE COURSE RECORD</button>
                            <a href="index.php" class="btn fw-bold btn-secondary mt-2 rounded-5">BACK</a>
                    </div>  
                </div>
              
                                
                                
                      
    </div>
<?php include '../layout/footer.php';  ?>