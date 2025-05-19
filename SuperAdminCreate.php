<?php
require_once 'layout/header.php';
require_once 'layout/sidebar.php';
require_once 'Database/Database.php';
require_once 'models/User.php';


if($_SERVER['REQUEST_METHOD'] == 'POST'){

    $db = new Database();
    $conn = $db->getConnection();

    User::setConnection($conn);

    User::create([
        'name' => $_POST['name'],
        'email' => $_POST['email'],
        'password' => password_hash($_POST['password'], PASSWORD_DEFAULT),
        'role' => $_POST['role'],
        'status' => $_POST['status'],
    ]);
}
?>


<form action="index.php" method="POST">
    <input type="text" name="name" placeholder="First Name" required>
    <input type="text" name="email" placeholder="Email" value="superadmin@gmail.com" readonly>
    <input type="password" name="password" placeholder="Password" required>
    <input type="text" name="role" placeholder="Role" value="super-admin" readonly>
    <input type="text" name="status" placeholder="Status" value="active" readonly>
    <input type="submit">
</form>

<?php include 'layout/footer.php'; ?>