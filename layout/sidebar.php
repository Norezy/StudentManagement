<?php if(strpos($_SERVER['REQUEST_URI'], '/StudentManagement/layout/sidebar.php')===0){
    
    } 
?>

<?php require "C:/xampp/htdocs/StudentManagement/layout/functions.php";?>
    
    <nav class="ps-3" style="min-width: 19%; max-width: fit-content; height: auto;">

        <div class="d-flex justify-content-center">
            <img src="http://localhost/StudentManagement/images/assets/highquallonglogo.png" alt="Logo" style="width: 200px; height: 80px; margin-top: 15px ;padding-right: 3%;">
        </div>

        
        <div class="mt-4 mb-3 ms-2 me-5">
                <span class = "navbar-text text-white fs-4 text-center fw-bold">
                    Welcome, <br> <strong class="fs-1"><?= strtoupper(strtok($_SESSION['name'], " ")); ?>!</strong>
                </span>
        </div>

        <ul class="nav flex-column">
            
            <li class="nav-item">
                <a class="nav-link text-white <?= $_SERVER['REQUEST_URI'] == '/StudentManagement/' ? 'active' : '' ?>" id="sidebar" href="/StudentManagement/">Dashboard</a>
            </li>
            
            <hr class="text-white" style="margin-left: 15px; max-width: fit-content; min-width: 200px; height: 3px; background-color: white;">

            <li class="nav-item">
                <a class="nav-link text-white <?= (strpos($_SERVER['REQUEST_URI'], '/StudentManagement/profile/') === 0 ? 'active' : '') ?>" id="sidebar" href="/StudentManagement/profile/">Profile</a>
            </li>

            <hr class="text-white" style="margin-left: 15px; width: 200px; height: 3px; background-color: white;">

            

            <?php if(isset($_SESSION['role']) && $_SESSION['role'] !== "instructor"):?>
            
            <li class="nav-item">
                <a class="nav-link text-white <?= (strpos($_SERVER['REQUEST_URI'], '/StudentManagement/students/') === 0 ? 'active' : '') ?>" id="sidebar" href="/StudentManagement/students/">Student Management</a>
            </li>

            <hr class="text-white" style="margin-left: 15px; width: 200px; height: 3px; background-color: white;">

            <li class="nav-item">
                <a class="nav-link text-white <?= (strpos($_SERVER['REQUEST_URI'], '/StudentManagement/subjects/') === 0 ? 'active' : '') ?>" id="sidebar" href="/StudentManagement/subjects/">Subject Management</a>
            </li>

            <hr class="text-white" style="margin-left: 15px; width: 200px; height: 3px; background-color: white;">

            <li class="nav-item">
                <a class="nav-link text-white <?= (strpos($_SERVER['REQUEST_URI'], '/StudentManagement/courses/') === 0 ? 'active' : '') ?>" id="sidebar" href="/StudentManagement/courses/">Course Management</a>
            </li>

            <hr class="text-white" style="margin-left: 15px; width: 200px; height: 3px; background-color: white;">

            <li class="nav-item">
                    <a class="nav-link text-white <?= ((strpos($_SERVER['REQUEST_URI'], '/StudentManagement/users/') === 0) ? 'active' : '') ?>" id="sidebar" href="/StudentManagement/users/">User Management</a>
            </li>

            <hr class="text-white" style="margin-left: 15px; width: 200px; height: 3px; background-color: white;">

            <?php else: ?>
                <li class="nav-item">
                <a class="nav-link text-white <?= (strpos($_SERVER['REQUEST_URI'], '/StudentManagement/AssignedSubjects/') === 0 ? 'active' : '') ?>" id="sidebar" href="/StudentManagement/AssignedSubjects/">Assigned Subjects</a>
                </li>

            <hr class="text-white" style="margin-left: 15px; width: 200px; height: 3px; background-color: white;">
            <?php endif; ?>
            

        </ul>

        <div class="mt-3">
            <button onclick="ConfirmLogout()" class="btn w-75 rounded-5 text-white fw-bold" style="background-color: #15803d; margin-left: 15px;">LOG OUT</a>
        </div>

    </nav>
