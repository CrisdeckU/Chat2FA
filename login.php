<?php
session_start();
if (isset($_SESSION['unique_id'])) {
  header("location: users.php");
}
$user_email_address = $_SESSION['user_email_address'];

?>

<?php include_once "header.php"; ?>

<body>
  <div class="wrapper">
    <section class="form login">
      <header>Confirme Codigo</header>
      <form action="#" method="POST" enctype="multipart/form-data" autocomplete="off">
        <div class="error-text"></div>
        <div class="field input">
            <label>Correo</label>
            <input type="text" name="email" placeholder="tucorreo@correo.com" value="<?php echo $user_email_address; ?>" required readonly>
        </div>
        <div class="field input">
          <label>Código 2FA</label>
          <input type="password" name="password" placeholder="Ingresa el Código 2FA" required>
          <i class="fas fa-eye"></i>
        </div>
        <div class="field button">
          <input type="submit" name="submit" value="Chatear">
        </div>
      </form>
    <!--  <div class="link">Aún no te has registrado? <a href="index.php">Regístrate acá</a></div> -->
    </section>
  </div>

  <script src="javascript/pass-show-hide.js"></script>
  <script src="javascript/login.js"></script>

</body>

</html>
