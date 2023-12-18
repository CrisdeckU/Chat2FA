<?php
session_start();
include_once "config.php";

$fname = mysqli_real_escape_string($conn, $_POST['fname']);
$lname = mysqli_real_escape_string($conn, $_POST['lname']);
$email = mysqli_real_escape_string($conn, $_POST['email']);
$img = mysqli_real_escape_string($conn, $_POST['img']);
$password = mysqli_real_escape_string($conn,$_POST['password']);

if (!empty($fname) && !empty($lname) && !empty($email) && !empty($password)) {
    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $sql = mysqli_query($conn, "SELECT * FROM users WHERE email = '{$email}'");
        if (mysqli_num_rows($sql) > 0) {
            echo "$email - ¡Este e-mail ya existe!";
        } else {
            
                            $ran_id = rand(time(), 100000000);
                            $status = "Disponible";
                            $insert_query = mysqli_query($conn, "INSERT INTO users (unique_id, fname, lname, email, img, status, password)
                                VALUES ({$ran_id}, '{$fname}','{$lname}', '{$email}', '{$img}', '{$status}','{$password}')");
                            if ($insert_query) {
                                $select_sql2 = mysqli_query($conn, "SELECT * FROM users WHERE email = '{$email}'");
                                if (mysqli_num_rows($select_sql2) > 0) {
                                    $result = mysqli_fetch_assoc($select_sql2);
                                    $_SESSION['unique_id'] = $result['unique_id'];
                                    echo "success";
                                    exit(); // Termina la ejecución para evitar que se envíen datos adicionales

                                } else {
                                    echo "¡Esta dirección de correo electrónico no existe!";
                                }

                        }


            
        }
    } else {
        echo "$email ¡No es un correo electrónico válido!";
    }
} else {
    echo "¡Todos los campos de entrada son obligatorios!";
}
