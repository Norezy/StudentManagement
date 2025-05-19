<?php
    session_start();
    if(!isset($_SESSION['email'])){
        header("Location: ../../auth/login.php");
        exit();
    }

    if($_SESSION['role'] == 'instructor'){
        header("Location: ../");
        exit();
    }

    if(!isset($_SESSION['email'])){
        header("Location: ../");
        exit();
    }
?>

<?php
    include '../../layout/header.php';
    include '../../layout/sidebar.php';
?>
<?php include '../../layout/footer.php';  ?>