<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <!-- bootstrap CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">  
        <!-- SweetAlert2 JS -->
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>

<?php
    session_start();
    if(!isset($_SESSION['email'])){
        header("Location: login.php");
    }else{
        if($_SERVER["REQUEST_METHOD"] == "POST"){
            session_unset();
            session_destroy();

            echo '<script>
                Swal.fire({
                    title: "Logout Successfully!",
                    icon: "success",
                    iconColor: "#0b7b55",
                    showConfirmButton: false,
                    timer: 1500,
                    timerProgressBar: true
                }).then(function() {
                    window.location.href = "login.php";
                });
            </script>';
        }else{
            header("Location: login.php");
        }
    }

    
?> 

    <!-- bootstrap js -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

</body>
</html>


