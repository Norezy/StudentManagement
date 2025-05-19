<?php
    require "../database/Database.php";

    $db = new Database();
    $conn = $db->getConnection();
?>

<!-- check if user is logged in and if the user is a instructor the user will be sent back to index.php -->
<?php
    session_start();
    if(!isset($_SESSION['email'])){
        header("Location: ../auth/login.php");
        exit();
    }

    if($_SESSION['role'] == 'instructor'){
        header("Location: ../");
    }

    include "../layout/header.php";
    include "../layout/sidebar.php";
?>


<!-- output a sweetalert if success or error -->
<?php
    if(isset($_SESSION['success'])){
        echo '<script> 
            Swal.fire({
                title: "Saved!",
                text: "User Has been Created Successfully!",
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
                text: "'.$_SESSION['error'].'",
                icon: "error",
                iconColor: "#b91c1c",
            });
        </script>';
    }
    unset($_SESSION['error']); 
?>
<!-- end of sweetalert -->


    <div class = "container-xxl bg-white rounded-start-5 p-5" style="max-width: 100%; height: 120vh;">

        <div class="card mx-auto border-0" style="width: 90%; height: 100%;">
        

            <div class="card-body">
            <h1 class="fw-bold" style="color: #061f5c; font-size: 60px; margin-top: 25px">USER MANAGEMENT</h1>
            <h3 class="fw-bold mb-4" style="color: #061f5c; font-size: 30px; ">CREATE STUDENT RECORD</h3>
                <form action="store.php" method="POST">
                    
                    <div class = "row">

                        <div class = "col-md-5 mb-3">
                            <label for="name" class="form-label fs-4">Name</label>
                            <input type="text" class="form-control border-0 border-bottom rounded-0 border-black shadow-none fs-5" id="name" name="name" required>
                        </div>

                        <div class = "col-md-5 mb-3">
                            <label for="email" class="form-label fs-4">Email address</label>
                            <input type="email" class="form-control border-0 border-bottom rounded-0 border-black shadow-none fs-5" id="email" name="email" required>
                        </div>

                    </div>

                    <div class = "row">
                        <div class = "col-md-6 mb-3">
                            <label for="password" class="form-label fs-4">Password</label>
                            <input type="password" class="form-control border-0 border-bottom rounded-0 border-black shadow-none fs-5" id="password" name="password" required>
                        </div>
                    </div>
                    <div class = "row">
                        <div class = "col-md-6 mb-3">
                            <label for="cpassword" class="form-label fs-4">Confirm Password</label>
                            <input type="password" class="form-control border-0 border-bottom rounded-0 border-black shadow-none fs-5" id="cpassword" name="cpassword" required>
                        </div>
                    </div>

                    <div class = "row">
                        <div class = "col-md-3 mb-3">
                            <label for="role" class="form-label fs-4">Role</label>
                            <select class="form-select border-0 border-bottom rounded-0 border-black shadow-none fs-5" id="role" name="role" required>

                                <?php if($_SESSION['role'] == 'admin'): ?>
                                    <option value="instructor">Instructor</option>
                                <?php else: ?>
                                    <option value="instructor">Instructor</option>
                                    <option value="admin">Admin</option>
                                <?php endif; ?>

                            </select>
                        </div>
                        
                        <div class = "col-md-3 mb-3">
                            <label for="status" class="form-label fs-4">Status</label>
                            <select class="form-select border-0 border-bottom rounded-0 border-black shadow-none fs-5" id="status" name="status" required>
                                    <option value="active">Active</option>
                                    <option value="inactive">Inactive</option>
                            </select>
                        </div>
                    </div>

                    <div class = "row" style="width: 250px; margin-left: -2px;">
                            <button type="submit" class="btn fw-bold text-white rounded-5 mt-2" style="background-color: #0b7b55">Create</button>
                            <a href="index.php" class="btn fw-bold btn-secondary mt-2 rounded-5">Cancel</a>
                    </div>

                </form>    
            </div>

        </div>
    </div>


<?php include "../layout/footer.php"; ?>