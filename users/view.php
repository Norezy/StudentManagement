<?php 
    require "../database/Database.php"; 
    require_once "../models/User.php";

    $db = new Database();
    $conn = $db->getConnection();
    Model::setConnection($conn);
    ob_start();
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

    if(!isset($_GET['id'])){
        header("Location: index.php");
        exit();
    }
?>

<?php    
    include '../layout/header.php';
    include '../layout/sidebar.php';

    $user = user::find($_GET['id']);

    if(empty($user)){
        http_response_code(404);
        include "../ErrorCode/404.php";
        exit;
    }

    if((($_SESSION['role']) == 'admin' || $_SESSION['role'] == 'super-admin') && ($user -> role == 'super-admin' || $user -> role == 'admin')){
        header("Location: index.php");
        ob_end_flush();
        exit();
    }   
?>

    <div class = "container-xxl bg-white rounded-start-5 main-content" style="max-width: 100%; height: auto;padding-right: 75px; padding-left: 125px; padding-top: 75px; min-height: 120vh;">

        <h1 class="fw-bold" style="color: #061f5c; font-size: 60px; margin-left: 15px;">USER MANAGEMENT</h1>
        <h2 class="fw-semibold mb-3" style="color: #061f5c; font-size: 40px; margin-left: 15px;">USER RECORD</h1>
        
        <div class = "card mx-auto w-100 mb-2 border-0">
            <div class = "card-body w-75">
                <div class ="d-flex align-items-left mb-2">
                    <div class = "text-center border-1 border-secondary fw-bold" style="color: #061f5c; font-size: 35px;"><?= $user -> name ?></div>
                </div>
                <div class ="d-flex justify-content-left mb-2">
                    <div class = "text-center border-1 border-secondary" style="color: #061f5c; font-size: 25px;"><strong>E-mail: </strong><?= $user -> email ?></div>
                    <div class = "text-center border-1 border-secondary" style="color: #061f5c; font-size: 25px; margin-left: 40px"><strong>Status: </strong><?= $user -> status?></div>
                </div>     
            </div>
        </div>  
                <div class="card border-0 ms-3">
                    <table id= "InstructorTable" class = "table">
                        <thead class = "text-white">
                            <tr>
                                <th class = "text-center text-white p-4">#</th>
                                <th class = "text-center text-white p-4">Catalog No</th>
                                <th class = "text-center text-white p-4">Subject Name</th>
                                <th class = "text-center text-white p-4">Course</th>
                                <th class = "text-center text-white p-4">Year Level</th>
                            </tr>
                        </thead>
                        <tbody> 
                            <?php if($user->subjects() != null):?>
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
                                </tr>
                                <?php endforeach; ?>
                            <?php endif;?>
                        </tbody> 
                    </table> 
                    <div class = "row" style="width: 250px; margin-left: -2px;">
                            <button onclick = "ViewUsersReport(<?= $user->id ?>);" class="btn fw-bold text-white rounded-5 mt-2" style="background-color: #0b7b55">GENERATE USER RECORD</button>
                            <a href="index.php" class="btn fw-bold btn-secondary mt-2 rounded-5">BACK</a>
                    </div>  
                </div>
              
                                
                                
                      
    </div>
<?php ob_end_flush(); include '../layout/footer.php';  ?>