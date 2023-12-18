<?php
// Include Configuration File
include('config.php');
include_once "header.php";
use RobThree\Auth\TwoFactorAuth;


if (isset($_GET["code"])) {

    $token = $google_client->fetchAccessTokenWithAuthCode($_GET["code"]);
    if (!isset($token['error'])) {

        $google_client->setAccessToken($token['access_token']);

        $_SESSION['access_token'] = $token['access_token'];

        $google_service = new Google_Service_Oauth2($google_client);

        $data = $google_service->userinfo->get();

        if (!empty($data['given_name'])) {
            $_SESSION['user_first_name'] = $data['given_name'];
        }

        if (!empty($data['family_name'])) {
            $_SESSION['user_last_name'] = $data['family_name'];
        }

        if (!empty($data['email'])) {
            $_SESSION['user_email_address'] = $data['email'];
        }

        if (!empty($data['gender'])) {
            $_SESSION['user_gender'] = $data['gender'];
        }

        if (!empty($data['picture'])) {
            $_SESSION['user_image'] = $data['picture'];
        }
    }
}

// Verificar si el usuario ha iniciado sesión
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

// Verificar si el usuario ya existe en la base de datos
$sql_check_user = mysqli_query($conn, "SELECT * FROM users WHERE email = '{$user_email_address}'");

if (mysqli_num_rows($sql_check_user) > 0) {
    // Usuario ya existe, redirigir a logged.php
    header("Location: login.php");
    exit(); // Asegúrate de salir después de la redirección
} else {
    $tfa = new TwoFactorAuth();
    
    if (empty($_SESSION["tfa_secret"])) {
        $_SESSION["tfa_secret"] = $tfa->createSecret();

    }
    $secret=$_SESSION["tfa_secret"];
    // Usuario no existe, mostrar el formulario prellenado
    ?>

    <!-- HTML del formulario prellenado -->
    <div class="wrapper">
    <section class="form signup">
      <header>CONFIRME SUS DATOS</header>
      <br>
      <div class="image" style="text-align: center;">
            <img  src="<?php echo $user_image; ?>" alt="Avatar" >
        </div>
    <form action="#" method="POST" enctype="multipart/form-data" autocomplete="off">
        <div class="error-text"></div>
        <div class="name-details">
            <div class="field input">
                <label>Nombre</label>
                <input type="text" name="fname" placeholder="Nombre" value="<?php echo $user_first_name; ?>" required>
            </div>
            <div class="field input">
                <label>Apellido</label>
                <input type="text" name="lname" placeholder="Apellido" value="<?php echo $user_last_name; ?>" required>
            </div>
        </div>
        <div class="field input">
            <label>Correo</label>
            <input type="text" name="email" placeholder="tucorreo@correo.com" value="<?php echo $user_email_address; ?>" required readonly>
        </div>
        <div class="field image" style="display:none;">
            <label>Avatar</label>
            <input type="text" name="img" placeholder="URL de la imagen" value="<?php echo $user_image; ?>" required readonly>
        </div>
        <div class="field input" style="display:none;">
          <label>Secret</label>
          <input type="password" name="password" placeholder="Secreto (NO MODIFICAR)" value="<?php echo $secret; ?>" required readonly>
          <i class="fas fa-eye"></i>
        </div>


        <div style="text-align: center;" class="auth">
            <header>2FA (OBLIGATORIO)</header>
            <p>No olvides ingresar el siguiente codigo en tu app 2FA, no podras volver a verlo en el futuro:</p>
            <h3><?php echo $secret; ?></h3>
            <p>O escanea el código:</p>
            <img style="border-radius: 0px;" src="<?= $tfa->getQRCodeImageAsDataUri('QRSecret',$secret)?>">
        </div>

        <div class="field button">
            <input type="submit" name="submit" value="Acceder al Chat">
        </div>

    </form>
    </section>
  <script src="javascript/signup.js"></script>
    <?php
}
?>


<html>
<head>
    <!-- ... (sección head) -->
</head>

