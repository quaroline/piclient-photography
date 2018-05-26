<?php
session_start();
ob_start();
header("Content-type: text/html; charset=utf-8");

if(isset($_SESSION['privateUser'])) {
  include_once 'modelo/usuario.class.php';
  $u = unserialize($_SESSION['privateUser']);
} else {
  header("location:index.php");
}
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
  <link rel="shortcut icon" href="img/favicon.png" type="image/x-icon"/>
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
      } else if ($u->tipo == 'Cliente') {
      ?>
      <li class="active"><a href="consultar-usuario.php" class="link">Pesquisar Usuário</a></li>
      <?php
      } else if ($u->tipo == 'Fotografo') {
      ?>
      <li class="active"><a href="upload-foto.php" class="link">Upload de Fotos</a></li>
      <li><a href="cadastrar-categoria.php" class="link">Cadastrar Categorias</a></li>
      <li class="active"><a href="consultar-usuario.php" class="link">Pesquisar Usuário</a></li>
    </ul>
    <?php
    }
  } else {
    header("location:index.php");
  }
  ?>
      <ul class="nav navbar-nav navbar-right">
        <li class="active"><a></a></li>
      </ul>
      <ul class="nav navbar-nav navbar-right">
        <li><a href="logout.php" class="link">Sair</a></li>
      </ul>
    </div>
  </div>
</nav>
<div class="container-fluid">
  <div style="margin-top:10%"></div>
  <div class="container">
