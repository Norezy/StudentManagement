<?php 
    require "../database/Database.php"; 
    require_once "../models/User.php";


    $db = new Database();
    $conn = $db->getConnection();
    Model::setConnection($conn);
    
    session_start();
?>

<?php
    if(!isset($_SESSION['email'])){
        header("Location: ../auth/login.php");
        exit();
    }

    if($_SESSION['role'] != 'instructor'){
        header("Location: ../");
        exit();
    }

    $user = user::find($_SESSION['userID']);
    
    
?>

<?php
    include '../layout/header.php';
    include '../layout/sidebar.php';
    if(empty($user)){
        http_response_code(404);
        include "../ErrorCode/404.php";
        exit;
    }
?>


    <div class = "container-xxl bg-white rounded-start-5 main-content" style="max-width: 100%; height: auto;padding-right: 75px; padding-left: 125px; padding-top: 75px; min-height: 120vh;">
                <h1 class="fw-bold mb-5" style="color: #061f5c; font-size: 60px; margin-left: 15px;">ASSIGNED SUBJECT</h1>
                <div class="card border-0 ms-3">
                    <table id= "InstructorTable" class = "table">
                        <thead class = "text-white">
                            <tr>
                                <th class = "text-center text-white p-4">#</th>
                                <th class = "text-center text-white p-4">Catalog No</th>
                                <th class = "text-center text-white p-4">Subject Name</th>
                                <th class = "text-center text-white p-4">Course</th>
                                <th class = "text-center text-white p-4">Year Level</th>
                                <th class = "text-center text-white p-4">Action</th>
                            </tr>
                        </thead>
                        <tbody> 
                            <?php if($user->subjects() !== null):?>
                                <?php $id=1; foreach($user->subjects() as $subject):?>
                                <tr>
                                    <td class = "text-center border-1 border-secondary"><?=$id++?></td>
                                    <td class = "text-center border-1 border-secondary"><?=$subject->catalog_no?></td>
                                    <td class = "text-center border-1 border-secondary"><?=$subject->name?></td>
                                    <td class = "text-center border-1 border-secondary"><?=$subject->course()->name?></td>
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
                                    ?></td>
                                    <td class = "text-center border-1 border-secondary"><a href="view.php?id=<?=$subject->id?>"class="btn btn-success rounded-3 fw-semibold border-0" style="background-color: #112c75;" title="View Details"><i class="fa-solid fa-magnifying-glass"></i></td>
                                </tr>
                                <?php endforeach; ?>
                            <?php endif;?>    
                        </tbody> 
                    </table> 
                </div>
              
                                
                                
                      
    </div>
<?php include '../layout/footer.php';  ?>