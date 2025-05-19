<?php 
    require "../database/Database.php"; 
    require "../models/Subject.php";

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
        exit();
    }

    $subjects = Subject::all();

    if($subjects === null){
        $_SESSION['error'] = "No subjects found! <br> <strong>Please create a subject first.</strong>";
        header("Location: create.php");
    }
?>

<?php
    include '../layout/header.php';
    include '../layout/sidebar.php';
?>


    <div class = "container-xxl bg-white rounded-start-5 main-content" style="max-width: 100%; height: auto;padding-right: 75px; padding-left: 75px; padding-top: 20px; min-height: 120vh;">

        <h1 class="fw-bold" style="color: #061f5c; font-size: 60px; margin-left: 15px;">SUBJECT MANAGEMENT</h1>
        
        <a href="create.php" class="btn btn-success rounded-5 fw-bold text-white" style="font-size: 20px; margin-left: 15px; margin-top: 10px">CREATE SUBJECT</a>
        <button  onclick = "SubjectReport()" class="btn btn-success  rounded-5 fw-bold text-white" style="font-size: 20px; margin-left: 5px; margin-top: 10px">GENERATE SUBJECT REPORT</button>
        
        <div class = "card mx-auto w-100 mb-5 border-0">
            <div class = "card-body">
                <table id= "usersTable" class = "table">
                    <thead class = "text-white">
                        <tr>
                            <th class = "text-center text-white p-4">Code</th>
                            <th class = "text-center text-white p-4">Catalog No</th>
                            <th class = "text-center text-white p-4">Name</th>
                            <th class = "text-center text-white p-4">Day</th>
                            <th class = "text-center text-white p-4">Time</th>
                            <th class = "text-center text-white p-4">Room</th>
                            <th class = "text-center text-white p-4">Course</th>
                            <th class = "text-center text-white p-4">Semester</th>
                            <th class = "text-center text-white p-4">Year Level</th>
                            <th class = "text-center text-white p-4">Instructor</th>
                            <th class = "text-center text-white p-4">Action</th>
                        </tr>
                    </thead>
                    <tbody>

                        <?php foreach($subjects as $subject): ?>
                            <tr>
                                <td class = "text-center border-1 border-secondary"><?= $subject -> code ?></td>
                                <td class = "text-center border-1 border-secondary"><?= $subject -> catalog_no ?></td>
                                <td class = "text-center border-1 border-secondary"><?= $subject -> name ?></td>
                                <td class = "text-center border-1 border-secondary"><?= $subject -> day ?></td>
                                <td class = "text-center border-1 border-secondary"><?= $subject -> time ?></td>
                                <td class = "text-center border-1 border-secondary"><?= $subject -> room ?></td>
                                <td class = "text-center border-1 border-secondary"><?= $subject->course()->code ?></td>
                                <td class = "text-center border-1 border-secondary">
                                <?php switch($subject->semester){
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
                                <td class = "text-center border-1 border-secondary"><?= $subject -> instructor($subject -> instructor_id)->name ?></td>

                                <td class="g-0 border-1 border-secondary">
                                    <div class="d-flex justify-content-center align-items-center gap-1">
                                        <a href="view.php?id=<?= $subject->id ?>" class="btn btn-success rounded-3 fw-semibold border-0" style="background-color: #112c75;" title="View Subject Record">
                                            <i class="fa-solid fa-magnifying-glass"></i>
                                        </a>
                                        
                                                
                                        <a href="edit.php?id=<?= $subject->id ?>" class="btn rounded-3 text-white border-0" style="background-color: #d97706;" title="Edit Subject Record">
                                            <i class="fa-solid fa-pen-to-square"></i>
                                        </a>
                                        
                                        <?php if($subject->students() == null): ?>
                                            <button onclick = "DelSubjectConfirm(<?= $subject -> id ?>);" class = "btn btn-danger rounded-3 fw-semibold text-white border-0" style="background-color: #b91c1c;" title="Delete Subject Record"><i class="fa-solid fa-trash"></i></button>
                                        <?php else: ?>
                                            <button class = "btn btn-danger rounded-3 fw-semibold text-white border-0" style="background-color: #b91c1c;" title="Delete" disabled><i class="fa-solid fa-trash"></i></button>
                                        <?php endif; ?>
                                        
                                    </div>
                                </td>

                            </tr>
                        <?php endforeach;?>
                    </tbody> 
                </table> 
            </div>
        </div>
    </div>
<?php include '../layout/footer.php';  ?>