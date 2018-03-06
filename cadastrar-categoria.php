<?php include_once ('base/header.php');?>


<div class="row content gambidiv">
    <form name="cadcategoria" method="post" action="cadastrar-categoria.php">
      <div class="form-group">
        <input type="text" name="txtcategoria" placeholder="Nome da Categoria" class="form-control" pattern="^[A-zÀ-ú]{2,30} ?[A-zÀ-ú]{1,30} ?[A-zÀ-ú]{2,30}$" required>
      </div>

      <div class="form-group">
        <input type="submit" value="Salvar" name="Salvar" class="btn btn-primary">
        <input type="reset" name="limpar" value="limpar" class="btn btn-danger">
      </div>

    </form>
  </div>

  <div class="col-sm-4"></div>
  <div class="col-sm-4">
    <?php
    include_once 'dao/categoriadao.class.php';
    include_once 'modelo/categoria.class.php';

    if(!isset($_POST['filtrarCategoria'])) {
      $categoriaDAO = new CategoriaDAO();
      $array = $categoriaDAO->buscarCategoria();
    }

    if(count($array) != 0) {
    ?>
    <div class="table-responsive">
      <table class="table table-striped table-bordered table-hover table-condensed">
        <thead>
          <tr>
            <th><center>Código</center></th>
            <th><center>Categoria</center></th>
          </tr>
        </thead>

        <tfoot>
          <tr>
            <th><center>Código</center></th>
            <th><center>Categoria</center></th>
          </tr>
        </tfoot>

        <tbody>
          <?php
          foreach($array as $a) {
            echo "<tr>";
              echo "<td>$a->idCategoria</td>";
              echo "<td>$a->nomeCategoria</td>";
            echo "</tr>";
          }//fecha foreach
          unset($array);
          ?>
        </tbody>
      </table>
    </div> <!-- div tabela -->
    <?php
    } else {
      echo "<h2>Não há categoria(s) para ser(em) exibidos!</h2>";
    }

    if(isset($_GET['id'])) {
      $categoriaDAO = new CategoriaDAO();
      $categoriaDAO->deletarCategoria($_GET['id']);
      header('location:filtrar-categoria.php');
      unset($_GET['id']);
    }
    ?>
    </div>
  </div>

<?php
if (isset($_POST['Salvar'])) {
  include_once 'modelo/categoria.class.php';
  include_once 'dao/categoriadao.class.php';
  include_once 'util/padronizacao.class.php';

  $categoriaNome = Padronizacao::padronizarMaiMin($_POST['txtcategoria']);
  $categoria = new Categoria();
  $categoria->categoriaNome = $categoriaNome;
  $categoriaDAO = new CategoriaDAO();
  $categoriaDAO->cadastrarCategoria($categoria);

  header("location:cadastrar-categoria.php");
}
?>
</div></div>
<div class="col-sm-3"></div>
<?php include_once ('base/footer.php'); ?>
