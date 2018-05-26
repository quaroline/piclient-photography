<?php
require_once "conexaobanco.class.php";

class FotografiaDAO {
  private $conexao = null;

  public function __construct() {
    $this->conexao = ConexaoBanco::getInstance();
  }

  public function __destruct() {}

    public function buscarFotografia() {
      try{
        $stat = $this->conexao->query("SELECT * FROM FOTOGRAFIA");
        $array = $stat->fetchAll(PDO::FETCH_CLASS,'FotografiaDAO');
        return $array;
      } catch (PDOException $ex) {
        echo 'Erro ao buscar fotografia.<br>'.$ex;
      }
    }

    public function filtrarFotografia() {
      try{
        $stat = $this->conexao->query("SELECT F.codigo, F.evento, F.descricao, F.nome_imagem, F.tamanho_imagem, F.tipo_imagem, F.imagem, C.nomeCategoria, U.nome FROM FOTOGRAFIA F, CATEGORIA C, USUARIO U WHERE U.IDUSUARIO = F.IDUSUARIO AND C.IDCATEGORIA = F.IDCATEGORIA");
        $array = $stat->fetchAll(PDO::FETCH_CLASS,'FotografiaDAO');
        return $array;
      } catch (PDOException $ex) {
        echo 'Erro ao buscar fotografia.<br>'.$ex;
      }
    }

    public function deletarFotografia($id) {
      try {
        $stat = $this->conexao->prepare("DELETE FROM fotografia WHERE codigo = ?");
        $stat->bindValue(1, $id);
        $stat->execute();
      } catch (PDOException $ex) {
        echo 'Erro ao deletar fotografia.<br>'.$ex;
      }
    }

    public function alterarFotografia($cat) {
      try {
        $stat = $this->conexao->prepare("UPDATE fotografia SET evento = ? WHERE codigo = ?");
        $stat->bindValue(1, $cat->evento);
        $stat->bindValue(2, $cat->codigo);
        $stat->execute();
      } catch (PDOException $exc) {
        echo 'Erro ao alterar o fotografia.<br>'.$exc;
      }
    }
  }
