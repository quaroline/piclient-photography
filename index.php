<?php
session_start();
ob_start();

if (isset($_SESSION['privateUser'])) {
  header("location:dashboard.php");
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="utf-8">
  <link rel="icon" href="https://getbootstrap.com/dist/css/bootstrap.min.css">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>PIClient &ndash; Login</title>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <link href="https://getbootstrap.com/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="estilo/signin.css" rel="stylesheet">
  <link href="estilo/estilo.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro" rel="stylesheet">
  <link rel="shortcut icon" href="img/favicon.png" type="image/x-icon"/>
</head>
<body><font face="Source Sans Pro">
  <div class="container">
    <form class="form-signin" name="login" action="" method="post">
      <div align="center">
        <img alt="PIClient" height="100" src="img/piclient.png">
      </div>
      <h2 class="form-signin-heading"><center><font color="#fff">Seja bem-vindo(a)!</font></center></h2>
        <div class="configdiv">
        <ul class="nav navbar-nav">
          <?php
          if (isset($_SESSION['privateUser'])) {
            include_once 'modelo/usuario.class.php';
            $u = unserialize($_SESSION['privateUser']);
          }
          ?>
        </ul>
      </div>
    </nav>
    <input type="text" class="form-control" name="txtlogin" placeholder="Login" required autofocus>
    <input type="password" class="form-control" name="txtsenha" placeholder="Senha" required>
    <div class="form-group">
      <select name="seltipo" class="form-control">
        <option value="Administrador">Administrador</option>
        <option value="Cliente">Cliente</option>
        <option value="Fotografo">Fotografo</option>
      </select>
    </div>
    <h2 class="form-signin-heading"><center><a href="cadastrar-usuario.php">Novo por aqui? Crie sua conta!</h2></font></center></a>
    <button class="btn btn-lg btn-default btn-block" type="submit" name="entrar" value="Entrar">Entrar</button>
  </form>
</div>

    <?php
    if (isset($_POST['entrar'])) {

      include_once 'modelo/usuario.class.php';
      include_once 'dao/usuariodao.class.php';
      include_once 'util/seguranca.class.php';

      //padronizacao
      $login = $_POST['txtlogin'];
      $senha = Seguranca::criptografarSenha($_POST['txtsenha']);
      $tipo = $_POST['seltipo'];

      //validacao
      $u = new Usuario();
      $u->login = $login;
      $u->senha = $senha;
      $u->tipo = $tipo;

      //DAO
      $uDAO = new UsuarioDAO();
      $usuario = $uDAO->verificarUsuario($u);

      if ($usuario && !is_null($usuario)) {
        var_dump($usuario);
        $_SESSION['privateUser'] = serialize($usuario);
        header("location:dashboard.php");
      } else {
        echo "Erro ao efetuar login. Verifique seu login e senha.";
      }
      unset($_POST['entrar']);
    }
    ?>
  </div>
</font></body>
</html>
