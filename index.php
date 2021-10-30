<?php

session_start();


?>

<!doctype html>
<html lang="pt-br">

<?php require_once "header.php"; ?>

<body class="text-center py-3">


  <h1>Login</h1>

  <main class="form-signin">
    <form name="form_sf_system" id="form_sf_system" method="POST" >
      
    <div class="mb-3">
        <label for="txtUsuario" class="form-label">Usuário</label>
        <input type="text" class="form-control" id="txtUsuario" name="txtUsuario">

      </div>
      <div class="mb-3">
        <label for="txtSenha" class="form-label">Senha</label>
        <input type="password" class="form-control" id="txtSenha" name="txtSenha">
      </div>
      <button type="submit" class="btn btn-success" id="btnAcessar" name="btnAcessar">Acessar</button>

    </form>
  </main>

  <div class="container">
    <p class="text-center text-light" style="background-color: firebrick;">
      <?php if (isset($_SESSION['loginErro'])) {
        echo $_SESSION['loginErro'];
        unset($_SESSION['loginErro']);
      } ?>
    </p>
  </div>

  <script>
    $("#btnAcessar").click(function(){
      var form = document.getElementById("form_sf_system");
      form.action = "/valida.php";
      form.submit();
	  });	
  </script>


</body>

</html>