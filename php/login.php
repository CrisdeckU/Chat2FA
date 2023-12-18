<?php
session_start();
include_once "config.php";
require_once './../vendor/autoload.php';
use RobThree\Auth\TwoFactorAuth;
$tfa = new TwoFactorAuth();

$email = mysqli_real_escape_string($conn, $_POST['email']);
$password = mysqli_real_escape_string($conn, $_POST['password']);
if (!empty($email) && !empty($password)) {
    $sql = mysqli_query($conn, "SELECT * FROM users WHERE email = '{$email}'");
    if (mysqli_num_rows($sql) > 0) {
        $row = mysqli_fetch_assoc($sql);
        if ($tfa->verifyCode($row['password'],$password)) {   
            $status = "Disponible";
            $sql2 = mysqli_query($conn, "UPDATE users SET status = '{$status}' WHERE unique_id = {$row['unique_id']}");
            if ($sql2) {
                $_SESSION['unique_id'] = $row['unique_id'];
                echo "success";
            } else {
                echo "Algo salió mal. ¡Inténtalo de nuevo!";
            }
        } else {
            echo "¡Correo electrónico o codigo 2FA son incorrectos!";
        }
    } else {
        echo "$email - ¡Este correo electrónico no existe!";
    }
} else {
    echo "¡Todos los campos de entrada son obligatorios!";
}
