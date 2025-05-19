<?php 
    require "../database/Database.php"; 
    require "../models/User.php";
    
    $db = new Database();
    $conn = $db->getConnection();
    User::setConnection($conn);

    ob_start();
    session_start();
?>
<?php
    include '../layout/header.php';
    include '../layout/sidebar.php';
?>
<?php

    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        $user = User::find($_POST['id']);
        $user->update([
            'status' => $_POST['status'] == 'active' ? 'inactive' : 'active'
        ]);
    }

    if(!isset($_SESSION['email'])){
        header("Location: ../auth/login.php");
        exit();
    }

    if($_SESSION['role'] == 'instructor'){
        header("Location: ../");
    }

    $users = User::all();

?>




    <div class = "container-xxl bg-white rounded-start-5 main-content" style="max-width: 100%; height: auto;padding-right: 75px; padding-left: 75px; padding-top: 20px; min-height: 120vh;">

        <h1 class="fw-bold" style="color: #061f5c; font-size: 60px; margin-left: 15px;">USER MANAGEMENT</h1>
        <?php if($_SESSION['role'] == 'admin'):?>
            <a href="create.php" class="btn btn-success rounded-5 fw-bold text-white border-0" style="font-size: 20px; margin-left: 15px; margin-top: 10px">CREATE INSTRUCTOR RECORD</a>
            <button  onclick = "InstructorReport();" class="btn btn-success  rounded-5 fw-bold text-white border-0" style="font-size: 20px; margin-left: 5px; margin-top: 10px">GENERATE INSTRUCTOR REPORT</button>
        <?php else: ?>
            <a href="create.php" class="btn btn-success rounded-5 fw-bold text-white border-0" style="font-size: 20px; margin-left: 15px; margin-top: 10px">CREATE USERS RECORD</a>
            <button  onclick = "UsersReport();" class="btn btn-success  rounded-5 fw-bold text-white border-0" style="font-size: 20px; margin-left: 5px; margin-top: 10px">GENERATE USERS REPORT</button>
        <?php endif; ?>
        
        <div class = "card mx-auto w-100 mb-5 border-0">
            <div class = "card-body">
                <table id= "usersTable" class = "table">
                    <thead class = "text-white">
                        <tr>
                            <th class = "text-center text-white p-4">#</th>
                            <th class = "text-center text-white p-4">Name</th>
                            <th class = "text-center text-white p-4">E-mail</th>
                            <th class = "text-center text-white p-4">Role</th>
                            <th class = "text-center text-white p-4">Status</th>
                            <th class = "text-center text-white p-4">Actions</th>
                        </tr>
                    </thead>
                    <tbody>

                        <?php $id=1; foreach($users as $user): 
                        if(($_SESSION['role'] == 'admin'|| $user -> role == 'super-admin') && ($user -> role == 'admin' || $user -> role == 'super-admin') ){continue;}?>
                            <tr>
                                <td class = "text-center border-1 border-secondary"><?= $id++;?></td>
                                <td class = "border-1 border-secondary"><?= ucwords($user -> name);?></td>
                                <td class = "border-1 border-secondary"><?= strtolower($user -> email);?></td>
                                <td class = "border-1 border-secondary">
                                    <?php if($user -> role == 'super-admin'){
                                    echo "Super-Admin";}
                                    else echo ucfirst($user -> role);
                                    ?>
                                </td>

                                <td class = "border-1 border-secondary">
                                    <?php if($user -> status == 'active'): ?>
                                        <button onclick = "DeactivateUser('<?= $user -> status ?>', <?= $user->id?>)" class = "btn btn-success rounded-3 fw-semibold text-white border-0" title="Deactivate">Activated</button>
                                    <?php else: ?>
                                        <button onclick = "ActivateUser('<?= $user -> status ?>',<?= $user->id?>)" class = "btn btn-danger rounded-3 fw-semibold text-white border-0" title="Activate">Deactivated</button>
                                    <?php endif; ?>
                                </td>

                                <td class="g-0 border-1 border-secondary">
                                    <?php if($user -> role == 'instructor'): ?>
                                        <a href="view.php?id=<?= $user->id ?>" class="btn btn-success rounded-3 fw-semibold border-0" style="background-color: #112c75;" title="View">
                                            <i class="fa-solid fa-magnifying-glass"></i>
                                        </a>
                                    <?php endif; ?>
                                            
                                    <a href="edit.php?id=<?= $user->id ?>" class="btn rounded-3 text-white border-0" style="background-color: #d97706;" title="Edit">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                    </a>
                                            
                                    <button onclick = "DeluserConfirm(<?= $user -> id ?>)" class = "btn btn-danger rounded-3 fw-semibold text-white border-0" style="background-color: #b91c1c;" title="Delete"><i class="fa-solid fa-trash"></i></button>
                                </td>

                            </tr>
                        <?php endforeach;?>

                    </tbody>  
            </div>
        </div>
    </div>

<?php ob_end_flush(); include '../layout/footer.php';  ?>