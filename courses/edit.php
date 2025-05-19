<?php
    require "../database/Database.php";
    require "../models/Course.php";
    $db = new Database();
    $conn = $db->getConnection();
?>

<!-- check if user is logged in and if the user is a instructor -->
<?php
    session_start();
    
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

    include "../layout/header.php";
    include "../layout/sidebar.php";
?>

<?php
        Course::setConnection($conn);
        $course = Course::find($_GET['id']);

        if(empty($course)){
            http_response_code(404);
            include "../ErrorCode/404.php";
            exit;
        }

        $_SESSION['coursecode'] = $course -> code;
        $_SESSION['coursename'] = $course -> name;    
?>

<!-- output a sweetalert if success or error -->
<?php
    if(isset($_SESSION['success'])){
        echo '<script> 
            Swal.fire({
                title: "Success!",
                text: "'.$_SESSION['success'].'",
                icon: "success",
                iconColor: "#0b7b55",
                }).then(function() {
                    window.location = "index.php";
            });
        </script>';
    }
    unset($_SESSION['success']);

    if(isset($_SESSION['error'])){
        echo '<script>
            Swal.fire({
                title: "Error!",
                html: "'.$_SESSION['error'].'",
                icon: "error",
                iconColor: "#b91c1c",
            });
        </script>';
    }
    unset($_SESSION['error']); 
?>
<!-- end of sweetalert -->

    <div class = "container-xxl bg-white rounded-start-5 p-5" style="max-width: 100%; height: 120vh;">

        <div class="card mx-auto border-0" style="width:80%; height: 100%;">
        

            <div class="card-body">
            <h1 class="fw-bold" style="color: #061f5c; font-size: 60px; margin-top: 25px">COURSE MANAGEMENT</h1>
            <h3 class="fw-bold mb-5" style="color: #061f5c; font-size: 30px; ">UPDATE COURSE RECORD</h3>

                <form action="update.php" method="POST">
                    <input type="hidden" name="id" value="<?= $course->id?>">
                    <div class = "row">
                        <div class = "col-md-6 mb-3">
                            <label for="code" class="form-label fs-4">Course Code</label>
                            <input type="text" class="form-control border-0 border-bottom rounded-0 border-black shadow-none fs-5" id="code" name="code" placeholder="e.g., BSIT" value="<?= $course->code ?>" required>
                        </div>
                    </div>

                    <div class = "row">
                        <div class = "col-md-6 mb-5">
                            <label for="name" class="form-label fs-4">Course Name</label>
                            <input type="text" class="form-control border-0 border-bottom rounded-0 border-black shadow-none fs-5" id="name" name="name" placeholder="e.g., Bachelor of Science in Information Technology" value="<?= $course->name?>" required>
                        </div>
                    </div>


                    <div class = "row" style="width: 250px; margin-left: -2px;">
                            <button type="submit" class="btn fw-bold text-white rounded-5 mt-2" style="background-color: #0b7b55">Update</button>
                            <a href="index.php" class="btn fw-bold btn-secondary mt-2 rounded-5">Cancel</a>
                    </div>

                </form>    
            </div>

        </div>
    </div>


<?php include "../layout/footer.php"; ?>