<?php 
    require "../database/Database.php"; 
    require "../models/Subject.php";
    require_once "../models/Grade.php";
    require_once "../models/Subject_Enrollment.php";

    $db = new Database();
    $conn = $db->getConnection();
    Subject::setConnection($conn);
    
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

    $subject = Subject::find($_GET['id']);
?>
 <?php
    include '../layout/header.php';
    include '../layout/sidebar.php';
    if(empty($subject)){
        http_response_code(404);
        include "../ErrorCode/404.php";
        exit;
    }
?>
 <?php   
    $enrolled_students_count = 0;
    foreach($subject->students() as $student){
        if($student->subject_enrollment()->status == 'enrolled'){
            $enrolled_students_count++;
        }
    }
    
?>




    <div class = "container-xxl bg-white rounded-start-5 main-content" style="max-width: 100%; height: auto;padding-right: 75px; padding-left: 125px; padding-top: 75px; min-height: 120vh;">

        <h1 class="fw-bold" style="color: #061f5c; font-size: 60px; margin-left: 15px;">SUBJECT MANAGEMENT</h1>
        <h2 class="fw-semibold mb-3" style="color: #061f5c; font-size: 40px; margin-left: 15px;">SUBJECT RECORD</h1>
        
        <div class = "card mx-auto w-100 mb-5 border-0">
            <div class = "card-body w-75">
                            <div class ="d-flex align-items-left mb-2">
                                <div class = "border-1 border-secondary fw-bold" style="color: #061f5c; font-size: 30px;"><?= $subject -> catalog_no . ': ' . $subject -> name ?></div>
                            </div>

                            <div class ="d-flex justify-content-left mb-4"">
                                <div class = "border-1 border-secondary" style="color: #061f5c; font-size:23px;"><strong>Total Enrolled Students:</strong> <?php if($enrolled_students_count < 10){echo '0';}?><?=$enrolled_students_count?></div>       
                                <div class = "border-1 border-secondary" style="color: #061f5c; font-size:23px; margin-left: 60px;"><strong>Assigned Instructor: </strong><?= $subject -> instructor($subject -> instructor_id)->name ?></div>
                            </div>
                            <div class ="d-flex justify-content-left mb-4"">
                                <div class = "text-center border-1 border-secondary" style="color: #061f5c; font-size:23px;"><strong>Course and Year level: </strong><?= $subject->course()->code ?> -
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
                                </div>   
                            </div>
                            <div class = "row" style="width: 250px; margin-left: -2px;">
                            <a href="subject_enrollment/enroll.php?id=<?= $subject->id?>"class="btn fw-bold text-white rounded-5" style="background-color: #0b7b55">ENROLL STUDENT</a>
            </div>
        </div>  
                <div class="card border-0 ms-3">
                    <table id= "enrollsubTable" class = "table">
                        <thead class = "text-white">
                            <tr>
                                <th class = "text-center text-white p-4">#</th>
                                <th class = "text-center text-white p-4">STUDENT ID</th>
                                <th class = "text-center text-white p-4">Name</th>
                                <th class = "text-center text-white p-4">Year Level</th>
                                <th class = "text-center text-white p-4">Grade</th>
                                <th class = "text-center text-white p-4">REMARKS</th>
                                <th class = "text-center text-white p-4">STATUS</th>
                                <th class = "text-center text-white p-4">Action</th>
                            </tr>
                        </thead>
                        <tbody> 
                                <?php $id=1; foreach($subject->students() as $student):?>
                                    <?php if($student->status == 'active'):?>
                                        <tr>
                                            <td class = "text-center border-1 border-secondary"><?=$id++?></td>
                                            <td class = "text-center border-1 border-secondary"><?=$student->student_id?></td>
                                            <td class = "text-center border-1 border-secondary"><?=$student->name?></td>
                                            <td class = "text-center border-1 border-secondary"><?php switch($student -> year_level){
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
                                            ?></td>
                                            <td class = "text-center border-1 border-secondary"><?= (Grade::getGrades($student->id, $subject->id) == NULL || Grade::getGrades($student->id, $subject->id)->grade == NULL) ? (empty(Grade::getGrades($student->id,$subject->id)->remarks) == 'incomplete' ? 'NOT YET SUBMITTED': 'Incomplete') : Grade::getGrades($student->id,$subject->id)->grade?></td>
                                            <td class = "text-center border-1 border-secondary"><?= Grade::getGrades($student->id, $subject->id) == NULL ? 'NOT YET SUBMITTED': ucfirst(Grade::getGrades($student->id,$subject->id)->remarks)?></td>
                                            <td class = "text-center border-1 border-secondary"><?= $student->subject_enrollment()->status == 'enrolled' ? 'Active' : ucfirst($student->subject_enrollment()->status) ?></td>

                                            <td class="g-0 border-1 border-secondary">
                                            <div class="d-flex justify-content-center align-items-center gap-1">                                  
                                                <a href="subject_enrollment/edit.php?studID=<?=$student->id?>&subID=<?=$_GET['id']?>" class="btn rounded-3 text-white border-0" style="background-color: #d97706;" title="Edit Student Record on Subject">
                                                <i class="fa-solid fa-pen-to-square"></i>
                                                </a>
                                                        
                                                <?php if($_SESSION['role'] == 'super-admin'):?>
                                                    <button onclick = "DelStudEnrollRecordConfirm(<?= Subject_Enrollment::findSubject_EnrollmentByStudIDandSubID($student->id, $subject->id)->id?>, <?= $_GET['id']?>);" class = "btn btn-danger rounded-3 fw-semibold text-white border-0" style="background-color: #b91c1c;" title="Delete Student Record on Subject"><i class="fa-solid fa-trash"></i></button>
                                                <?php else: ?>
                                                    <button onclick = "DelStudEnrollRecordConfirm(<?= $student->subject_enrollment() -> id ?>, <?= $_GET['id']?>);" class = "btn btn-danger rounded-3 fw-semibold text-white border-0" style="background-color: #b91c1c;" disabled><i class="fa-solid fa-trash"></i></button>
                                                <?php endif; ?>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endif;?>
                                <?php endforeach; ?>
                        </tbody> 
                    </table> 
                    <div class = "row" style="width: 250px; margin-left: -2px;">
                            <button onclick="AssignedSubjectReport(<?= $subject->id?>)" class="btn fw-bold text-white rounded-5 mt-2" style="background-color: #0b7b55">GENERATE SUBJECT RECORD</button>
                            <a href="index.php" class="btn fw-bold btn-secondary mt-2 rounded-5">BACK</a>
                    </div>  
                </div>
              
                                
                                
                      
    </div>
<?php include '../layout/footer.php';  ?>