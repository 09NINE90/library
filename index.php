<?php 
  session_start();
//   if(isset($_SESSION['id'])){
//     header("location: user.php");
//   }
?>

<?php include_once "header.php"; ?>
<body>
  <div class="wrapper">
    <section class="form login">
      <header>Вход</header>
      <form action="#" method="POST" enctype="multipart/form-data" autocomplete="off">
        <div class="error-text"></div>
        <div class="field input">
          <input type="text" name="login" placeholder="Логин" required>
        </div>
        <div class="field input">
          <input type="password" name="password" placeholder="Пароль" required>
          <i class="fas fa-eye"></i>
        </div>
        <div class="field button">
          <input type="submit" name="submit" value="Войти">
        </div>
      </form>
    </section>
  </div>
  
  <script src="js/pass-show-hide.js"></script>
  <script src="js/login.js"></script>

</body>
</html>