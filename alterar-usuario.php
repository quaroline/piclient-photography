<?php
include_once 'base/header.php';
include_once 'modelo/usuario.class.php';
include_once 'dao/usuariodao.class.php';

if(isset($_SESSION['privateUser'])) {
  include_once 'modelo/usuario.class.php';
  $u = unserialize($_SESSION['privateUser']);

  if($u->tipo != 'Administrador') {
    header("location:dashboard.php");
  }
} else {
  header("location:dashboard.php");
}

if (isset($_GET['id'])) {
  $usuarioDAO = new UsuarioDAO();
  $u = "where idUsuario=".$_GET['id'];
  $array = $usuarioDAO->filtrarUsuario($u);
  unset($_GET['id']);
}
?>
<form name="alterarusuario" method="post" action="" class="text-center">
  <div class="form-group">
    <input type="text" name="idUsuario" placeholder="Código" class="form-control" readonly="readonly" value="<?php if(isset($array)) echo $array[0]->idUsuario?>">
  </div>
  <div class="form-group">
    <input type="text" name="nome" placeholder="Nome" class="form-control" value="<?php if(isset($array)) echo $array[0]->nome?>" pattern="^[A-zÀ-ú]{2,30} ?[A-zÀ-ú]{1,30} ?[A-zÀ-ú]{1,30} ?[A-zÀ-ú]{1,30} ?[A-zÀ-ú]{1,30}$" required>
  </div>
  <div class="form-group">
    <input type="text" name="telefone" placeholder="Telefone" class="form-control" value="<?php if(isset($array)) echo $array[0]->telefone?>" pattern="^\(?\d{2}\)?[\s-]?\d{4}-?\d{4}$">
  </div>
  <div class="form-group">
    <input type="text" name="endereco" placeholder="Endereço" class="form-control" value="<?php if(isset($array)) echo $array[0]->endereco?>" pattern="^[^@()\/?]{1,100}$">
  </div>
  <div class="form-group">
    <input type="email" name="email" placeholder="E-mail" class="form-control" value="<?php if(isset($array)) echo $array[0]->email?>" required>
  </div>
  <div class="form-group">
    <input type="text" name="login" placeholder="Login" class="form-control" value="<?php if(isset($array)) echo $array[0]->login?>" required=required pattern="^[\dA-z]{2,30}$">
  </div>
  <div class="form-group">
    <input type="password" name="senha" placeholder="Senha" class="form-control" value="<?php if(isset($array)) echo $array[0]->senha?>">
  </div>

  <div class="form-group">
    <select name="seltipo" class="form-control">
      <option value="Administrador"<?php if(isset($array))if($array[0]->tipo == "Administrador") echo "selected='selected'"?>>Administrador</option>
      <option value="Cliente"<?php if(isset($array))if($array[0]->tipo == "Cliente") echo "selected='selected'"?>>Cliente</option>
      <option value="Fotografo"<?php if(isset($array))if($array[0]->tipo == "Fotografo") echo "selected='selected'"?>>Fotografo</option>
    </select>
  </div>
  <div class="form-group">
    <input type="submit" name="alterar" value="Alterar" class="btn btn-primary">
    <input type="reset" name="Limpar" value="Limpar" class="btn btn-danger">
  </div>
</form>

<?php
if(isset($_POST['alterar'])) {

  include_once 'util/padronizacao.class.php';
  include_once 'util/seguranca.class.php';

  $idUsuario = $_POST['idUsuario'];
  $nome = Padronizacao::padronizarMaiMin($_POST['nome']);
  $telefone = $_POST['telefone'];
  $endereco = Padronizacao::padronizarMaiMin($_POST['endereco']);
  $email = $_POST['email'];
  $login = $_POST['login'];
  $senha = Seguranca::criptografarSenha($_POST['senha']);
  $tipo = $_POST['seltipo'];

  $alt = new Usuario();
  $alt->idUsuario = $idUsuario;
  $alt->nome = $nome;
  $alt->telefone = $telefone;
  $alt->endereco = $endereco;
  $alt->email = $email;
  $alt->login = $login;
  $alt->senha = $senha;
  $alt->tipo = $tipo;

  $uDAO = new UsuarioDAO();
  $uDAO->alterarUsuario($alt);

  echo $uDAO->alterarUsuario($alt);
  header("location:filtrar-usuario.php");
}
?>
</div>

<?php include_once ('base/footer.php') ?>
