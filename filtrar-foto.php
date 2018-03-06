<?php include_once ('base/header.php');

if(isset($_SESSION['privateUser'])) {
  include_once 'modelo/usuario.class.php';
  $u = unserialize($_SESSION['privateUser']);
  if($u->tipo != 'Administrador') {
    header("location:dashboard.php");
  }
  include_once 'dao/fotografiadao.class.php';
  include_once 'modelo/fotografia.class.php';

  $catDAO = new FotografiaDAO();
  $array = $catDAO->buscarFotografia();

  if(count($array)!=0) {
    ?>
    <div class="container">
        <div class="row">
          <div class="card">
            <table class="table">
              <tbody>
                <table class='table table-striped table-bordered table-hover table-condensed'>
                  <thead>
                    <tr>
                      <th><center>Alterar</center></th>
                      <th><center>Excluir</center></th>
                      <th><center>Evento</center></th>
                      <th><center>Descrição</center></th>
                      <th><center>Nome da Imagem</center></th>
                      <th><center>Tamanho</center></th>
                      <th><center>Extensão</center></th>
                      <th><center>Imagem</center></th>
                      <th><center>Fotografia</center></th>
                      <th><center>Fotografado por</center></th>
                    </tr>
                  </thead>

                  <tbody>
                    <?php
                    include_once 'dao/conexaobanco.class.php';
                    include_once 'dao/fotografiadao.class.php';

                    $fotoDAO = new FotografiaDAO();
                    $array = $fotoDAO->filtrarFotografia();

                    foreach($array as $a) {
                        echo "<tr>";
                          echo "<td><A href='alterar-foto.php?id=$a->codigo'>$a->codigo</a></td>";
                          echo "<td><a href='filtrar-foto.php?id=$a->codigo'><img src='img/remove-icon.png' height='20' width='20' alt='Excluir'></a></td>";
                          echo "<td>$a->evento</td>";
                          echo "<td>$a->descricao</td>";
                          echo "<td>$a->nome_imagem</td>";
                          echo "<td>$a->tamanho_imagem</td>";
                          echo "<td>$a->tipo_imagem</td>";
                          echo "<td><img src='data:image/jpeg;base64,".base64_encode($a->imagem)."' height='50' width='50'/></td>";
                          echo "<td>$a->nomeCategoria</td>";
                          echo "<td>$a->nome</td>";
                        echo "<tr>";
                    }
                    ?>
                  </tbody>

                  <tfoot>
                    <tr>
                      <th><center>Alterar</center></th>
                      <th><center>Excluir</center></th>
                      <th><center>Evento</center></th>
                      <th><center>Descrição</center></th>
                      <th><center>Nome da Imagem</center></th>
                      <th><center>Tamanho</center></th>
                      <th><center>Extensão</center></th>
                      <th><center>Imagem</center></th>
                      <th><center>Fotografia</center></th>
                      <th><center>Fotografado por</center></th>
                    </tr>
                  </tfoot>

                  <?php
                } else {
                  echo "Não há fotografia(s) para ser(em) exibidos!";
                }
              }
              ?>
                <?php
                if(isset($_GET['id'])) {
                  $fotografiaDAO = new FotografiaDAO();
                  $fotografiaDAO->deletarFotografia($_GET['id']);
                  header('location:filtrar-foto.php');
                  unset($_GET['id']);
                }
                    ?>
                  </div></div>
                </tbody>
              </table>
            </div>
          </table>
        </div>

    <?php include_once ('base/footer.php') ?>
