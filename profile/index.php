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
    
    $user = user::find($_SESSION["userID"]);
    
    
?>

<?php
$id=1;
    include '../layout/header.php';
    include '../layout/sidebar.php';

    if(isset($_SESSION['success'])){
        echo '<script>
            Swal.fire({
                title: "Success!",
                text: "'.$_SESSION['success'].'",
                icon: "success",
                iconColor: "#0b7b55",
            });
        </script>';
    }
    unset($_SESSION['success']);
    
    if(empty($user)){
        http_response_code(404);
        include "../ErrorCode/404.php";
        exit;
    }
?>


    <div class = "container-xxl bg-white rounded-start-5 main-content" style="max-width: 100%; height: auto;padding-right: 75px; padding-left: 125px; padding-top: 75px; min-height: 120vh;">
        
        <div class="row ms-1">
            <div class="col-md-2" style="margin-right: 20px;">
            <img src="../images/avatars/<?= !empty($user->avatar) ? htmlspecialchars($user->avatar) : 'default-avatar.jpg'; ?>?t=<?= time(); ?>" class="rounded-circle" style="width: 150px; height: 150px; object-fit: cover; border: 2px solid #061f5c;" alt="User Avatar">
            </div>
            <div class="col">
                <h1 class="fw-bold" style="color: #061f5c; font-size: 60px;"><?= $user -> name ?></h1>
                <h2 class="fw-semibold" style="color: #061f5c; font-size: 40px;"><?= strtoupper($user->role) ?></h2>
            </div>

            <form method="POST" action="update_avatar.php" enctype="multipart/form-data">
                <!-- Hidden file input -->
                <input type="file" id="avatarInput" name="avatar" accept="image/*" style="display: none;">
                
                <!-- Upload button -->
                <button type="button" id="uploadBtn" class="btn text-white mt-1 fw-bold" style="background-color: #0b7b55; margin-left: 5px">Upload Avatar</button>
                
                <!-- Other form fields if any -->
                <input type="hidden" name="user_id" value="<?= $user->id; ?>">
            </form>

            <script>
                document.getElementById('uploadBtn').addEventListener('click', function() {
                document.getElementById('avatarInput').click();
            });

            document.getElementById('avatarInput').addEventListener('change', function() {
                if (this.files && this.files[0]) {
                    this.closest('form').submit();
                }
            });
            </script>
        
        </div>
        <div class = "card mx-auto w-100 mb-2 border-0">
            <div class = "card-body w-75">
                <div class ="d-flex justify-content-between mb-2">
                    <div class = "text-center border-1 border-secondary" style="color: #061f5c; font-size: 35px;"><strong>E-mail: </strong><?= strtolower($user -> email) ?></div>
                    <div class = "text-center border-1 border-secondary" style="color: #061f5c; font-size: 35px;"><strong>Status: </strong><?= ucfirst($user -> status)?></div>
                </div>
            </div>
        </div>
        

                <div class="card border-0 ms-3">
            <?php if($_SESSION['role']=='instructor'):?>
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
                            <?php if($user->subjects() !== null):?>
                                <?php foreach($user->subjects() as $subject):?>
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
                <?php endif; ?>
                    <div class = "row" style="width: 250px; margin-left: -2px;">
                    
                            <a href="edit.php?id=<?=$_SESSION['userID']?>" class="btn fw-bold btn-secondary mt-2 rounded-5 border-0" style="background-color: #d97706">EDIT PROFILE</a>
                            <?php if($_SESSION['role']=="instructor"):?>
                                <button onclick = "ViewProfileReport(<?= $user->id ?>);" class="btn fw-bold text-white rounded-5 mt-2" style="background-color: #0b7b55">GENERATE USER RECORD</button>
                            <?php endif;?>
                    </div>  
        </div>                 
    </div>
<?php include '../layout/footer.php';  ?>