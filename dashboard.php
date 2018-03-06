<?php include_once ('base/header.php') ?>

<div class="row content gambidiv">
  <font size="4">
    <?php
    if (isset($_SESSION['privateUser'])) {

      include_once 'modelo/usuario.class.php';
      $u = unserialize($_SESSION['privateUser']);
      echo "E aí, </font><font size='5'><b>".$u->nome."</b></font><font size='4'>! Essa é a sua <i>dashboard</i>. ;)</font>";
    }
    ?>


  <form name="filtrofoto" method="post" action="" class="text-center">
    <div class="form-group">
      <input type="text" name="txtpesquisa" class="form-control" placeholder="Digite o que deseja pesquisar">
    </div>
    <div class="radio-inline">
      <label class="radio-inline">
        <input type="radio" name="rdfiltro" value="codigo">Código
      </label>
      <label class="radio-inline">
        <input type="radio" name="rdfiltro" value="evento">Nome
      </label>
      <label class="radio-inline">
        <input type="radio" name="rdfiltro" value="descricao">Descrição
      </label>
      <label class="radio-inline">
        <input type="radio" name="rdfiltro" value="tamanho_imagem">Tamanho
      </label>
      <label class="radio-inline">
        <input type="radio" name="rdfiltro" value="idCategoria">Categoria
      </label>
      <label class="radio-inline">
        <input type="radio" name="rdfiltro" value="idUsuario">Fotografado por
      </label>
      <label class="radio-inline">
        <input type="radio" name="rdfiltro" value="todos" checked="checked">Todos
      </label>
    </div>
    <div class="form-group"><br>
      <input type="submit" name="filtrarUsuario" value="Pesquisar" class="btn btn-primary">
    </div>
  </form>
</div>
</div>

<?php
include_once 'dao/conexaobanco.class.php';

if(isset($_POST['filtrarUsuario'])) {

  $pesq = $_POST['txtpesquisa'];

  if($pesq != "") {

    $filtro = $_POST['rdfiltro'];

    if($filtro == 'codigo') {
      $result=mysqli_query($conexao,"SELECT * FROM FOTOGRAFIA WHERE codigo = ".$pesq);
    }else if($filtro == 'evento') {
      $result=mysqli_query($conexao,"SELECT * FROM FOTOGRAFIA WHERE evento like '%$pesq%'");
    }else if($filtro == 'descricao') {
      $result=mysqli_query($conexao,"SELECT * FROM FOTOGRAFIA WHERE descricao like '%$pesq%'");
    }else if($filtro == 'tamanho_imagem') {
      $result=mysqli_query($conexao,"SELECT * FROM FOTOGRAFIA WHERE tamanho_imagem like '%$pesq%'");
    }else if($filtro == 'idCategoria') {
      $result=mysqli_query($conexao,"SELECT * FROM FOTOGRAFIA WHERE idCategoria like '%$pesq%'");
    }else if($filtro == 'idUsuario') {
      $result=mysqli_query($conexao,"SELECT * FROM FOTOGRAFIA WHERE idUsuario like '%$pesq%'");
    } else {
      $result=mysqli_query($conexao,"SELECT * FROM FOTOGRAFIA");
    }
  } else {
    $result=mysqli_query($conexao,"SELECT * FROM FOTOGRAFIA");
  }

  unset($_POST['filtrarUsuario']);

  $array = mysqli_query($conexao,"SELECT * FROM FOTOGRAFIA");
  ?>
  <div class="container">
    <div class="col-sm-3">
      <div class="row">
        <div class="card">
          <table class="table">
            <tbody>
              <div class="container">
                <div class="table-responsive">
                <?php
                while($array = $result->fetch_assoc()) {
                  echo "<img src='data:image/jpeg;base64,".base64_encode($array['imagem'])."' height='150' width='150'/>  ";
                }
                ?>
                </div>
              </div>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
<?php
} else {
  ?>

</div>
</div>

<div class="container">
  <div class="col-sm-3">
    <div class="row">
      <div class="card">
        <table class="table">
          <tbody>
            <div class="container">
              <div class="table-responsive">
                <?php
                include_once 'dao/conexaobanco.class.php';
                include_once 'dao/fotografiadao.class.php';

                $fotoDAO = new FotografiaDAO();
                $array = $fotoDAO->buscarFotografia();

                foreach($array as $a) {
                  echo "<img src='data:image/jpeg;base64,".base64_encode($a->imagem)."' height='150' width='150'/> ";
                }
                ?>
              </div>
            </div>
          </tbody>
        </table>
      </div>
    </table>
  </div>
    <?php
  }

  ?>

  <?php include_once ('base/footer.php') ?>
