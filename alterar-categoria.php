<?php
include_once 'base/header.php';
include_once 'modelo/categoria.class.php';
include_once 'dao/categoriadao.class.php';

if(isset($_SESSION['privateUser'])) {
  include_once 'modelo/categoria.class.php';
  $u = unserialize($_SESSION['privateUser']);

  if($u->tipo != 'Administrador') {
    header("location:dashboard.php");
  }
} else {
  header("location:dashboard.php");
}

if (isset($_GET['id'])) {
  $catDAO = new CategoriaDAO();
  $query = "where idCategoria=".$_GET['id'];
  $array = $catDAO->filtrarCategoria($query);

  unset($_GET['id']);
}
?>
<form name="alterarlivro" method="post" action="">

  <div class="form-group">
    <input type="text" name="idCategoria" placeholder="Código" class="form-control" readonly="readonly" value="<?php if(isset($array)) echo $array[0]->idCategoria?>">
  </div>

  <div class="form-group">
    <input type="text" name="nomeCategoria" placeholder="Categoria" class="form-control" value="<?php if(isset($array)) echo $array[0]->nomeCategoria?>" pattern="^[A-zÀ-ú]{2,30} ?[A-zÀ-ú]{1,30} ?[A-zÀ-ú]{2,30}$" required>
  </div>

  <div class="form-group">
    <input type="submit" name="alterar" value="Alterar" class="btn btn-primary">
    <input type="reset" name="Limpar" value="Limpar" class="btn btn-danger">
  </div>
</form>
<?php
if(isset($_POST['alterar'])) {
  include_once 'util/padronizacao.class.php';

  $idCategoria = $_POST['idCategoria'];
  $nomeCategoria = Padronizacao::padronizarMaiMin($_POST['nomeCategoria']);

  $cat = new Categoria();
  $cat->idCategoria = $idCategoria;
  $cat->nomeCategoria = $nomeCategoria;

  $catDAO = new CategoriaDAO();
  $catDAO->alterarCategoria($cat);
  header("location:filtrar-categoria.php");
}
?>
</div>
</body>
</html>
