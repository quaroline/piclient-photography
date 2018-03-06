<?php
session_start();
ob_start();
header("Content-type: text/html; charset=utf-8");
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
  <title>PIClient</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <link rel="stylesheet" href="estilo/main.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro" rel="stylesheet">
</head>

<body><font face="Source Sans Pro">
  <nav class="navbar navbar-toggleable-md navbar-light bg-faded navbar-fixed-top" style="background:#20D396;">
    <div id="navbar" class="navbar-collapse collapse">
      <ul class="nav navbar-nav">
        <li class="active"><a></a></li>
        <li><img src="img/pilogobranco.png" height="40" width="40"></a></li>
        <li class="active"><a></a></li>
        <li class="active"><a href="dashboard.php" class="link">Início</a>
        <?php
        if (isset($_SESSION['privateUser'])) {
          include_once 'modelo/usuario.class.php';
          $u = unserialize($_SESSION['privateUser']);
          if ($u->tipo == 'Administrador') {
        ?>
          <li class="dropdown">
            <a href="#" class="dropdown-toggle link" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Cadastrar <span class="caret"></span></a>
            <ul class="dropdown-menu">
              <li><a href="cadastrar-usuario.php" class="link">Usuários</a></li>
              <li><a href="upload-foto.php" class="link">Fotografias</a></li>
              <li><a href="cadastrar-categoria.php" class="link">Categorias</a></li>
            </ul>
          </li>
          <li class="dropdown">
            <a href="#" class="dropdown-toggle link" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Editar <span class="caret"></span></a>
            <ul class="dropdown-menu">
              <li><a href="filtrar-usuario.php" class="link">Usuários</a></li>
              <li><a href="filtrar-foto.php" class="link">Fotografias</a></li>
              <li><a href="filtrar-categoria.php" class="link">Categorias</a></li>
            </ul>
          </li>
          <li class="active"><a href="consultar-usuario.php" class="link">Pesquisar Usuário</a></li>
        </ul>

      <?php
      } else {
      ?>
      <li class="active"><a href="index.php" class="link">Login</a></li>
      <?php
      }
    }
  ?>
</div>
</nav>

<div style="margin-top:10%"></div>
<div class="container">

<div class="row content gambidiv">
      <form name="cadusuario" method="post">
        <div class="form-group">
          <input type="text" name="txtnome" placeholder="Nome" class="form-control" pattern="^[A-zÀ-ú]{2,30} ?[A-zÀ-ú]{1,30} ?[A-zÀ-ú]{1,30} ?[A-zÀ-ú]{1,30} ?[A-zÀ-ú]{1,30}$" required>
        </div>

        <div class="form-group">
          <input type="text" name="txttelefone" placeholder="Telefone" class="form-control" pattern="^\(?\d{2}\)?[\s-]?\d{4,5}-?\d{4}$">
        </div>

        <div class="form-group">
          <input type="text" name="txtendereco" placeholder="Endereço" class="form-control">
        </div>

        <div class="form-group">
          <input type="email" name="txtemail" placeholder="E-mail" class="form-control" required=required>
        </div>

        <div class="form-group">
          <input type="text" name="txtlogin" placeholder="Login" class="form-control" required=required pattern="^[\dA-z]{2,30}$">
        </div>

        <div class="form-group">
          <input type="password" name="txtsenha" placeholder="Senha" class="form-control" required=required>
        </div>

        <div class="form-group">
          <select name="seltipo" class="form-control">
            <?php
            if(isset($_SESSION['privateUser'])) {
              include_once 'modelo/usuario.class.php';
              $user = unserialize($_SESSION['privateUser']);

              if ($user->tipo == 'Administrador') {echo"<option value='Administrador'>Administrador</option>";}
            }
            ?>
            <option value="Cliente">Cliente</option>
            <option value="Fotografo">Fotografo</option>
          </select>
        </div>

        <div class="form-group">
          <input type="submit" value="Salvar" name="Salvar" class="btn btn-primary">
          <input type="reset" name="limpar" value="limpar" class="btn btn-danger">
        </div>
      </form>
    </div>

<?php
if (isset($_POST['Salvar'])) {
  include_once 'modelo/usuario.class.php';
  include_once 'dao/usuariodao.class.php';
  include_once 'util/seguranca.class.php';
  include_once 'util/padronizacao.class.php';

  //padronizacao
  $nome = Padronizacao::padronizarMaiMin($_POST['txtnome']);
  $telefone = $_POST['txttelefone'];
  $endereco = Padronizacao::padronizarMaiMin($_POST['txtendereco']);
  $email = $_POST['txtemail'];
  $login = $_POST['txtlogin'];
  $senha = Seguranca::criptografarSenha($_POST['txtsenha']);
  $tipo = $_POST['seltipo'];

  //validacao
  $user = new Usuario();
  $user->nome = $nome;
  $user->telefone = $telefone;
  $user->endereco = $endereco;
  $user->email = $email;
  $user->login = $login;
  $user->senha = $senha;
  $user->tipo = $tipo;

  //banco
  $userDAO = new UsuarioDAO();

  //header("location:index.php");

  include_once 'modelo/usuario.class.php';
  include_once 'util/validacao.class.php';
  $nome = $_POST['txtnome'];
  $telefone = $_POST['txttelefone'];
  $usuario = $_POST['txtlogin'];
  $erros = array();
  if(!Validacao::validarNomeUsuario($nome)){
    $erros[] = "Nome inválido!";
  }
  if(!Validacao::validarTelefone($telefone)){
    $erros[] = "Telefone inválido!";
  }
  if(!Validacao::validarUsuario($usuario)){
    $erros[] = "Usuário inválido!";
  }
  if(count($erros) == 0){
    $user->nome = Padronizacao::padronizarMaiMin($_POST['txtnome']);
    $user->telefone = $_POST['txttelefone'];
    $user->usuario = $_POST['txtlogin'];
    $_SESSION['user'] = serialize($user);
    $userDAO->cadastrarUsuario($user);
    header("location:consultar-usuario.php");
  } else {
    $_SESSION['erros'] = serialize($erros);
    var_dump($erros);
    //header("location:resposta.php");
  }
}
?>

<?php include_once ('base/footer.php') ?>
