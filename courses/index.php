<?php 
    require "../database/Database.php"; 
    require "../models/Course.php";

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

    $courses = Course::all();

    if($courses === null){
        $_SESSION['error'] = "No Courses found! <br> <strong>Please create a Course first.</strong>";
        header("Location: create.php");
    }
?>

<?php
    include '../layout/header.php';
    include '../layout/sidebar.php';
?>


    <div class = "container-xxl bg-white rounded-start-5 main-content" style="max-width: 100%; height: auto;padding-right: 75px; padding-left: 75px; padding-top: 20px; min-height: 120vh;">

        <h1 class="fw-bold" style="color: #061f5c; font-size: 60px; margin-left: 15px;">COURSE MANAGEMENT</h1>
        
        <a href="create.php" class="btn btn-success rounded-5 fw-bold text-white" style="font-size: 20px; margin-left: 15px; margin-top: 10px">CREATE COURSE</a>
        <button  onclick = "CourseReport();" class="btn btn-success  rounded-5 fw-bold text-white" style="font-size: 20px; margin-left: 5px; margin-top: 10px">GENERATE COURSE REPORT</button>
        
        <div class = "card mx-auto w-100 mb-5 border-0">
            <div class = "card-body">
                <table id= "usersTable" class = "table">
                    <thead class = "text-white">
                        <tr>
                            <th class = "text-center text-white p-4">ID</th>
                            <th class = "text-center text-white p-4">Code</th>
                            <th class = "text-center text-white p-4">Name</th>
                            <th class = "text-center text-white p-4">Action</th>
                           
                        </tr>
                    </thead>
                    <tbody>

                        <?php $id=1; foreach($courses as $course): ?>
                            <tr>
                                <td class = "text-center border-1 border-secondary"><?= $id++ ?></td>
                                <td class = "text-center border-1 border-secondary"><?= $course -> code ?></td>
                                <td class = "text-center border-1 border-secondary"><?= $course -> name ?></td>
                            

                                <td class="g-0 border-1 border-secondary text-center">
                                    <div class="d-flex justify-content-center align-items-center gap-2">
                                        <a href="view.php?id=<?= $course->id ?>" class="btn btn-success rounded-3 fw-semibold border-0" style="background-color: #112c75;" title="View">
                                            <i class="fa-solid fa-magnifying-glass"></i>
                                        </a>
                                        <a href="edit.php?id=<?= $course->id ?>" class="btn rounded-3 text-white border-0" style="background-color: #d97706;" title="Edit">
                                            <i class="fa-solid fa-pen-to-square"></i>
                                        </a>
                                        <?php if($course->students() == null): ?>
                                            <button onclick="DelCourseConfirm(<?= $course->id ?>);" class="btn btn-danger rounded-3 fw-semibold text-white border-0" style="background-color: #b91c1c;" title="Delete">
                                                <i class="fa-solid fa-trash"></i>
                                            </button>
                                        <?php else: ?>
                                            <button class="btn btn-danger rounded-3 fw-semibold text-white" style="background-color: #b91c1c;" title="Delete" disabled>
                                                <i class="fa-solid fa-trash"></i>
                                            </button>
                                        <?php endif; ?>
                                    </div>
                                </td>

                            </tr>
                        <?php endforeach;?>

                    </tbody>  
            </div>
        </div>
    </div>
<?php include '../layout/footer.php';  ?>