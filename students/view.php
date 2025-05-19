<?php 
    require "../database/Database.php"; 
    require "../models/Student.php";
    require "../models/Grade.php";

    $db = new Database();
    $conn = $db->getConnection();
    Student::setConnection($conn);
    
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
    $student = Student::find($_GET['id']);
    
    
?>

<?php
    include '../layout/header.php';
    include '../layout/sidebar.php';
    
    if(empty($student)){
        http_response_code(404);
        include "../ErrorCode/404.php";
        exit;
    }
?>


    <div class = "container-xxl bg-white rounded-start-5 main-content" style="max-width: 100%; height: auto;padding-right: 75px; padding-left: 125px; padding-top: 75px; min-height: 120vh;">

        <h1 class="fw-bold" style="color: #061f5c; font-size: 60px; margin-left: 15px;">STUDENT MANAGEMENT</h1>
        <h2 class="fw-semibold mb-2" style="color: #061f5c; font-size: 40px; margin-left: 15px;">STUDENT RECORD</h1>
        
        <div class = "card mx-auto w-100 mb-3 border-0">
            <div class = "card-body w-100">
                            <div class="col">
                                <div class="row">
                                    <div class="border-1 border-secondary fw-bold" style="color: #061f5c; font-size: 35px;">
                                        <?= $student->name ?>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="border-1 border-secondary fw-bold" style="color: #061f5c; font-size: 25px;">
                                        <strong></strong><?= $student->course()->name . " (".$student->course()->code.")"?>
                                    </div>
                                </div>
                            </div>

                            <div class ="d-flex justify-content-left mb-1"">
                                <div class = "text-center border-1 border-secondary" style="color: #061f5c; font-size:25px;"><strong>Student ID: </strong><?= $student->student_id?></div>       
                                <div class = "text-center border-1 border-secondary" style="color: #061f5c; font-size:25px; margin-left: 145px"><strong>Year Level: </strong> 
                                <?php switch($student -> year_level){
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
                                        }
                                    ?></div>
                                    <div class = "text-center border-1 border-secondary" style="color: #061f5c; font-size:25px; margin-left: 200px"><strong>Status: </strong><?= ucfirst($student->status)?> </div>   
                            
                                </div>
                            <div class="d-flex justify-content-left">
                                <div class = "text-center border-1 border-secondary" style="color: #061f5c; font-size:25px;"><strong>Gender: </strong><?= ucfirst($student->gender)?> </div>   
                                <div class = "text-center border-1 border-secondary" style="color: #061f5c; font-size:25px; margin-left: 220px"><strong>Date of Birth: </strong><?= $student->birthdate?> </div>   
                                </div>
            </div>
        </div>  
                <div class="card border-0 ms-3">
                    <table id= "listEnrollTable" class = "table">
                        <thead class = "text-white">
                            <tr>
                                <th class = "text-center text-white p-4">#</th>
                                <th class = "text-center text-white p-4">Catalog No</th>
                                <th class = "text-center text-white p-4">Subject Name</th>
                                <th class = "text-center text-white p-4">Year Level</th>
                                <th class = "text-center text-white p-4">Semester</th>
                                <th class = "text-center text-white p-4">Assigned Instructor</th>
                                <th class = "text-center text-white p-4">Grade</th>
                                <th class = "text-center text-white p-4">Remarks</th>
                            </tr>
                        </thead>
                        <tbody> 
                                <?php $id=1; foreach($student->subjects() as $subject):?>
                                <tr>
                                    <td class = "text-center border-1 border-secondary"><?=$id++?></td>
                                    <td class = "text-center border-1 border-secondary"><?=$subject->catalog_no?></td>
                                    <td class = "text-center border-1 border-secondary"><?=$subject->name?></td>
                                    <td class = "text-center border-1 border-secondary">
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
                                        }
                                    ?>
                                    </td>
                                    <td class = "text-center border-1 border-secondary">
                                    <?php switch($subject -> semester){
                                        case 1:
                                            echo "1st Semester";
                                            break;
                                        case 2:
                                            echo "2nd Semester";
                                            break;
                                        default:
                                            echo "N/A";
                                        }
                                    ?>
                                    </td>
                                    <td class = "text-center border-1 border-secondary"><?=$subject->instructor($subject->instructor_id)->name?></td>
                                    <td class = "text-center border-1 border-secondary"><?= (Grade::getGrades($student->id, $subject->id) == NULL || Grade::getGrades($student->id, $subject->id)->grade == NULL) ? (empty(Grade::getGrades($student->id,$subject->id)->remarks) == 'incomplete' ? 'NOT YET SUBMITTED': 'Incomplete'): Grade::getGrades($student->id,$subject->id)->grade?></td>
                                    <td class = "text-center border-1 border-secondary"><?= Grade::getGrades($student->id, $subject->id) == NULL ? 'NOT YET SUBMITTED': ucfirst(Grade::getGrades($student->id,$subject->id)->remarks)?></td>
                                    </tr>
                                <?php endforeach; ?>
                        </tbody> 
                    </table> 
                    <div class = "row" style="width: 250px; margin-left: -2px;">
                            <button onclick="ViewStudentRecord(<?=$student->id?>)"class="btn fw-bold text-white rounded-5 mt-2" style="background-color: #0b7b55">GENERATE STUDENT RECORD</button>
                            <a href="index.php" class="btn fw-bold btn-secondary mt-2 rounded-5">BACK</a>
                    </div>  
                </div>
              
                                
                                
                      
    </div>
<?php include '../layout/footer.php';  ?>