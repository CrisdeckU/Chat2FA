<?php
// Include Configuration File
include('config.php');

if (!isset($_SESSION['access_token'])) {
    // Redirigir al usuario a la página de inicio de sesión si no ha iniciado sesión
    header("Location: index.php");
    exit();
}

// Cargar información del usuario desde la sesión
$user_image = $_SESSION["user_image"];
$user_first_name = $_SESSION['user_first_name'];
$user_last_name = $_SESSION['user_last_name'];
$user_email_address = $_SESSION['user_email_address'];

?>

<html>
<head>
    <!-- ... (sección head) -->
</head>

<body>
    <div class="container">
        <br />
        <h2 align="center" style="text-align: center;"> User Dashboard <img src="img/logoGoogle.png"></h2>
        <br />
        <div>
            <div class="col-lg-4 offset-4">
                <div class="card">
                    <div class="card-header">Welcome User</div>
                    <div class="card-body">
                        <img src="<?php echo $user_image; ?>" class="rounded-circle container"/>
                        <h3><b>Name :</b> <?php echo $user_first_name . ' ' . $user_last_name; ?></h3>
                        <h3><b>Email :</b> <?php echo $user_email_address; ?></h3>
                        <h3><a href="logout.php">Logout</a></h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
