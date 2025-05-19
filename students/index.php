<?php 
    require "../database/Database.php"; 
    require "../models/Student.php";

    $db = new Database();
    $conn = $db->getConnection();
    Student::setConnection($conn);
    
    ob_start();
    session_start();
?>

<?php
    include '../layout/header.php';
    include '../layout/sidebar.php';
?>

<?php
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        $student = Student::find($_POST['id']);
        $student->status = $_POST['status'] == 'active' ? 'inactive' : 'active';
        $stmt = $student->save();
    }

    if(!isset($_SESSION['email'])){
        header("Location: ../auth/login.php");
        exit();
    }

    if($_SESSION['role'] == 'instructor'){
        header("Location: ../");
    }

    $students = Student::all();

    if($students === null){
        $_SESSION['error'] = "No students found! <br> <strong>Please create a student first.</strong>";
        header("Location: create.php");
    }
?>




    <div class = "container-xxl bg-white rounded-start-5 main-content" style="max-width: 100%; height: auto;padding-right: 75px; padding-left: 75px; padding-top: 20px; min-height: 120vh;">

        <h1 class="fw-bold" style="color: #061f5c; font-size: 60px; margin-left: 15px;">STUDENT MANAGEMENT</h1>
        
        <a href="create.php" class="btn btn-success rounded-5 fw-bold text-white" style="font-size: 20px; margin-left: 15px; margin-top: 10px">CREATE STUDENT RECORD</a>
        <button  onclick = "StudentReport();" class="btn btn-success  rounded-5 fw-bold text-white" style="font-size: 20px; margin-left: 5px; margin-top: 10px">GENERATE STUDENT REPORT</button>
        
        <div class = "card mx-auto w-100 mb-5 border-0">
            <div class = "card-body">
                <table id= "usersTable" class = "table">
                    <thead class = "text-white">
                        <tr>
                            <th class = "text-center text-white p-4">ID</th>
                            <th class = "text-center text-white p-4">Student ID</th>
                            <th class = "text-center text-white p-4">Name</th>
                            <th class = "text-center text-white p-4">Gender</th>
                            <th class = "text-center text-white p-4">Birthdate</th>
                            <th class = "text-center text-white p-4">Course</th>
                            <th class = "text-center text-white p-4">Year Level</th>
                            <th class = "text-center text-white p-4">Status</th>
                            <th class = "text-center text-white p-4">Action</th>
                        </tr>
                    </thead>
                    <tbody>

                        <?php $id=1; foreach($students as $student): ?>
                            <tr>
                                <td class = "text-center border-1 border-secondary"><?= $id++ ?></td>
                                <td class = "text-center border-1 border-secondary"><?= $student -> student_id ?></td>
                                <td class = "text-center border-1 border-secondary"><?= $student -> name ?></td>
                                <td class = "text-center border-1 border-secondary"><?= ucfirst($student -> gender) ?></td>
                                <td class = "text-center border-1 border-secondary"><?= $student -> birthdate ?></td>
                                <td class = "text-center border-1 border-secondary"><?= $student->course()->code ?></td>
                                <td class = "text-center border-1 border-secondary">
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
                                ?>
                                </td>
                                <td class = "text-center border-1 border-secondary">
                                    <?php if($student -> status == 'active'): ?>
                                        <button onclick = "DeactivateUser('<?= $student -> status ?>', <?= $student->id?>)" class = "btn btn-success rounded-3 fw-semibold text-white border-0" title="Deactivate">Activated</button>
                                    <?php else: ?>
                                        <button onclick = "ActivateUser('<?= $student -> status ?>',<?= $student->id?>)" class = "btn btn-danger rounded-3 fw-semibold text-white border-0" title="Activate">Deactivated</button>
                                    <?php endif; ?>
                                </td>
                                <td class="g-0 border-1 border-secondary">
                                    <div class="d-flex justify-content-center align-items-center gap-1">
                                        <a href="view.php?id=<?= $student->id ?>" class="btn btn-success rounded-3 fw-semibold border-0" style="background-color: #112c75;" title="View Student Record">
                                            <i class="fa-solid fa-magnifying-glass"></i>
                                        </a>
                                    
                                                
                                        <a href="edit.php?id=<?= $student->id ?>" class="btn rounded-3 text-white border-0" style="background-color: #d97706;" title="Edit Student Record">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                        </a>
                                                
                                    
                                            <button onclick = "DelStudentConfirm(<?= $student -> id ?>);" class = "btn btn-danger rounded-3 fw-semibold text-white border-0" style="background-color: #b91c1c;" title="Delete Student Record"><i class="fa-solid fa-trash"></i></button>
                                    </div>
                                </td>

                            </tr>
                        <?php endforeach;?>
                </tbody>  
            </div>
        </div>
    </div>
<?php 
ob_end_flush(); 
include '../layout/footer.php';  
?>