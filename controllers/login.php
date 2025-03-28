<?php
session_start();
include("../dB/config.php");

if (isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Secure the query using prepared statements
    $query = "SELECT userId, firstName, lastName, email, password, phoneNumber, gender, birthday, verification, role 
              FROM users WHERE email = ? AND password = ? LIMIT 1";

    $stmt = $conn->prepare($query);
    $stmt->bind_param("ss", $email, $password);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result && mysqli_num_rows($result) > 0) {
        $data = mysqli_fetch_assoc($result);

        $_SESSION['auth'] = true;
        $_SESSION['role'] = $data['role'];
        $_SESSION['authUser'] = [
            'userId'    => $data['userId'],
            'firstName' => $data['firstName'],
            'lastName'  => $data['lastName'],
            'email'     => $data['email'],
            'phoneNumber' => $data['phoneNumber'],
            'gender'    => $data['gender'],
            'birthday'  => $data['birthday'],
        ];

        // Redirect based on role
        if ($data['role'] == 'admin') {
            header("Location: ../view/admin/index.php");
        } elseif ($data['role'] == 'user') {
            header("Location: ../view/users/index.php");
        } else {
            header("Location: ../login.php");
        }
        exit();
    } else {
        $_SESSION['message'] = "Invalid Credentials";
        $_SESSION['code'] = "error";
        header("Location: ../login.php");
        exit();
    }
} else {
    $_SESSION['message'] = "Unauthorized Access";
    $_SESSION['code'] = "error";
    header("Location: ../login.php");
    exit();
}
?>
