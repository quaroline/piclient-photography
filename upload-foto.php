<?php include ('base/header.php')?>

<div class="row content gambidiv">
  <?php
  if(isset($_SESSION['privateUser'])) {
    include_once 'modelo/usuario.class.php';
    $u = unserialize($_SESSION['privateUser']);
    if($u->tipo == 'Administrador' || $u->tipo == 'Fotografo') {
  ?>
      <form enctype="multipart/form-data" method="post" accept-charset="utf-8">
        <div class="form-group">
          <input name="nome_evento" type="text" class="form-control" required placeholder="Título da Fotografia">
        </div>

        <div class="form-group">
          <input name="descricao_evento" type="textarea" class="form-control" placeholder="Descrição da Fotografia">
        </div>

        <div class="form-group">
          <input type="text" name="usuario" placeholder="<?php echo $u->nome ?>" class="form-control" readonly="readonly" value="<?php $u->idUsuario ?>">
        </div>

        <div class="form-group">
          <select class="form-control" name="categoria" required>
            <?php
            include_once 'dao/categoriadao.class.php';
            $categoriaDAO = new CategoriaDAO();
            $resultado = $categoriaDAO->buscarCategoria();

            if(sizeof($resultado) != 0) {
              foreach($resultado as $c) {
                echo "<option value='$c->idCategoria'>$c->nomeCategoria</option>";
              }
              unset($resultado);
            }
            ?>
          </select>
        </div>

        <input type="hidden" name="MAX_FILE_SIZE" value="99999999"/>

        <div class="form-group">
          <input name="imagem" type="file" required pattern="^[a-zA-Z0-9-_\.]+\.(jpg|gif|png)$" accept="image/png, image/jpeg">
        </div>

        <div class="form-group">
          <input type="submit" value="Salvar" name="Salvar" class="btn btn-primary">
          <input type="reset" name="Limpar" value="Limpar" class="btn btn-danger">
        </div>
      </form>
      <?php
    } else {
      header("location:dashboard.php");
    }
    if (isset($_POST['Salvar'])) {
      include_once 'dao/conexaobanco.class.php';
      $nomeEvento = $_POST['nome_evento'];
      $descricaoEvento = $_POST['descricao_evento'];
      $imagem = $_FILES['imagem']['tmp_name'];
      $tamanho = $_FILES['imagem']['size'];
      $tipo = $_FILES['imagem']['type'];
      $nome = $_FILES['imagem']['name'];
      $idCategoria = $_POST['categoria'];
      $idUsuario = $u->idUsuario;

      if ( $imagem != NULL ) {
        $fp = fopen($imagem, "rb");
        $conteudo = fread($fp, $tamanho);
        $conteudo = addslashes($conteudo);
        fclose($fp);
      }

      $queryInsercao = "INSERT INTO fotografia (evento, descricao, nome_imagem, tamanho_imagem, tipo_imagem, imagem, idCategoria, idUsuario) VALUES ('$nomeEvento', '$descricaoEvento','$nome','$tamanho', '$tipo','$conteudo','$idCategoria','$idUsuario')";

      mysqli_query($conexao, $queryInsercao);
      if(mysqli_affected_rows($conexao) > 0) {
        print "A imagem foi salva na base de dados.";
      } else {
        print "Não foi possível salvar a imagem na base de dados."; }
      }
    }

    include ('base/footer.php') ?>
  </body>
  </html>
