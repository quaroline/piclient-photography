<?php include_once ('base/header.php') ?>


<form name="filtrofoto" method="post" action="" class="text-center">
  <div class="form-group">
    <input type="text" name="txtpesquisa" class="form-control" placeholder="Digite o que deseja pesquisar">
  </div>
  <div class="radio-inline">
    <label class="radio-inline">
      <input type="radio" name="rdfiltro" value="idUsuario">Código
    </label>
    <label class="radio-inline">
      <input type="radio" name="rdfiltro" value="nome">Nome
    </label>
    <label class="radio-inline">
      <input type="radio" name="rdfiltro" value="tipo">Tipo
    </label>
    <label class="radio-inline">
      <input type="radio" name="rdfiltro" value="todos" checked="checked">Todos
    </label>
  </div>
  <div class="form-group"><br>
    <input type="submit" name="filtrarUsuario" value="Pesquisar" class="btn btn-primary">
  </div>
</form>

<?php
include_once 'dao/usuariodao.class.php';
include_once 'modelo/usuario.class.php';

if(isset($_POST['filtrarUsuario'])) {

  $pesq = "";
  $pesq = $_POST['txtpesquisa'];
  $query = "";

  if($pesq != "") {

    $filtro = $_POST['rdfiltro'];

    if($filtro == 'idUsuario') {
      $query = "where idUsuario = ".$pesq;
    } else if ($filtro == 'nome') {
      $query = "where nome like '%".$pesq."%'";
    } else if ($filtro == 'tipo') {
      $query = "where tipo like '%".$pesq."%'";
    } else {
      $query = "where tipo like '%$pesq%' or idUsuario like '%$pesq%' or nome like '%$pesq%'";
    }
  } else {
    $filtro = $_POST['rdfiltro'];

    if($filtro == 'idUsuario') {
      $query = "";
    } else if ($filtro == 'nome') {
      $query = "";
    } else if ($filtro == 'tipo') {
      $query = "";
    } else {
      $query = "";
    }
  }

  $usuarioDAO = new UsuarioDAO();
  $array = $usuarioDAO->filtrarUsuario($query);

  unset($_POST['filtrarUsuario']);

} else {

  $usuarioDAO = new UsuarioDAO();
  $array = $usuarioDAO->buscarUsuario();

}

if(count($array) != 0) {
?>
<div class="table-responsive">
  <table class="table table-striped table-bordered table-hover table-condensed">
    <thead>
      <tr>
        <th><center>Código</center></th>
        <th><center>Nome</center></th>
        <th><center>Tipo</center></th>
        <th><center>Telefone</center></th>
        <th><center>E-mail</center></th>
      </tr>
    </thead>

    <tfoot>
      <tr>
        <th><center>Código</center></th>
        <th><center>Nome</center></th>
        <th><center>Tipo</center></th>
        <th><center>Telefone</center></th>
        <th><center>E-mail</center></th>
      </tr>
    </tfoot>

    <tbody>
      <?php
      foreach($array as $a) {
        echo "<tr>";
          echo "<td>$a->idUsuario</td>";
          echo "<td>$a->nome</td>";
          echo "<td>$a->tipo</td>";
          echo "<td>$a->telefone</td>";
          echo "<td>$a->email</td>";
        echo "</tr>";
      }
      unset($array);
      ?>
    </tbody>
  </table>
</div>
<?php
} else {
  echo "<h2>Não há usuario(s) para ser(em) exibidos!</h2>";
}

?>
</div>
</div>
<?php include_once ('base/footer.php') ?>
