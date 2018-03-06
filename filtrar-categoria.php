<?php include_once ('base/header.php');?>

<form name="filtrocategoria" method="post" class="text-center">
  <div class="form-group">
    <input type="text" name="txtpesquisa" class="form-control" placeholder="Digite o que deseja pesquisar">
  </div>
  <div class="radio-inline">
    <label class="radio-inline">
      <input type="radio" name="rdfiltro" value="idCategoria">Código
    </label>
    <label class="radio-inline">
      <input type="radio" name="rdfiltro" value="nomeCategoria">Categoria
    </label>
  </div>
  <div class="form-group"><br>
    <input type="submit" name="filtrarCategoria" value="Pesquisar" class="btn btn-primary">
  </div>
</form>

  <?php
  include_once 'dao/categoriadao.class.php';
  include_once 'modelo/categoria.class.php';

  if(isset($_POST['filtrarCategoria'])) {

    $pesq = "";
    $pesq = $_POST['txtpesquisa']; //O que o user digitou
    $query = "";

    if($pesq != "") {

      $filtro = $_POST['rdfiltro']; //RadioButton

      if($filtro == 'idCategoria') {
        $query = "where idCategoria = ".$pesq;
      } else if ($filtro == 'nomeCategoria') {
        $query = "where nomeCategoria like '%".$pesq."%'";
      } else {
        $query = "";
      }
    }//fecha if isset rdfiltro

    $categoriaDAO = new CategoriaDAO();
    $array = $categoriaDAO->filtrarCategoria($query);

    unset($_POST['filtrarCategoria']);

  } else {

    $categoriaDAO = new CategoriaDAO();
    $array = $categoriaDAO->buscarCategoria();

  }

if(isset($_SESSION['privateUser'])) {
  include_once 'modelo/categoria.class.php';
  $u = unserialize($_SESSION['privateUser']);
  if($u->tipo != 'Administrador') {
    header("location:dashboard.php");
  }
  include_once 'dao/categoriadao.class.php';
  include_once 'modelo/categoria.class.php';

  $catDAO = new CategoriaDAO();
  $array = $catDAO->buscarCategoria();

  if(count($array)!=0) {
    ?>
    <div class="table-responsive">
      <div class="col-sm-4"></div>
      <div class="col-sm-4">
        <table class="table table-striped table-bordered table-hover table-condensed">
          <thead>
            <tr>
              <th>Alterar</th>
              <th>Excluir</th>
              <th>Categoria</th>
            </tr>
          </thead>
          <tfoot>
            <tr>
              <th>Alterar</th>
              <th>Excluir</th>
              <th>Categoria</th>
            </tr>
          </tfoot>

          <tbody>
            <?php
            foreach($array as $a) {
              echo "<tr>";
                echo "<td><A href='alterar-categoria.php?id=$a->idCategoria'>$a->idCategoria</a></td>";
                echo "<td><a href='filtrar-categoria.php?id=$a->idCategoria'><img src='img/remove-icon.png' height='20' width='20' alt='Excluir'></a></td>";
                echo "<td>$a->nomeCategoria</td>";
              echo "</tr>";
            }
            ?>
          </tbody>
        </table>
      </div>
    <?php
    } else {
      echo "Não há categoria(s) para ser(em) exibidos!";
    }

    if(isset($_GET['id'])) {
      $categoriaDAO = new CategoriaDAO();
      $categoriaDAO->deletarCategoria($_GET['id']);
      header('location:filtrar-categoria.php');
      unset($_GET['id']);
    }
  }
  ?>
</div>
</div>
<div class="col-sm-4"></div>
<?php include_once ('base/footer.php') ?>
