<?php if(!isset($_SESSION['email'])){
        header("Location: ../auth/login.php");
        exit();
}?>

<div class = "container-xxl bg-white rounded-start-5 d-flex" style="max-width: 100%; height: 120vh;">
    <div class="d-flex flex-column justify-content-center align-items-center w-100 h-100">
        <img src = "/sms/ErrorCode/assets/images/404.svg" alt = "404 Error" class = "img-fluid w-50 h-50">
            <h1 class = "text-center">ERROR 404</h1>
            <div>record has not been found</div>
            <br>
            <a href="/SMS/" class = "btn btn-primary" style="background-color: #061f5c" >click here to go back to homepage</a>
        </div>
    </div>
</div>