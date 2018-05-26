<?php
require_once "conexaobanco.class.php";

class CategoriaDAO {
  private $conexao = null;

  public function __construct() {
    $this->conexao = ConexaoBanco::getInstance();
  }

  public function __destruct() {}

    public function cadastrarCategoria($categoria) {
      try {
        $stat = $this->conexao->prepare("INSERT INTO categoria(nomeCategoria) VALUES (?);");
        $stat->bindValue(1,$categoria->categoriaNome);
        $stat->execute();
        $this->conexao = null;
      } catch (PDOException $ex) {
        echo "Erro ao efetuar cadastro de categoria.<br>".$ex;
      }
    }

    public function buscarCategoria() {
      try{
        $stat = $this->conexao->query("SELECT * FROM categoria");
        $array = $stat->fetchAll(PDO::FETCH_CLASS,'CategoriaDAO');
        return $array;
      } catch (PDOException $ex) {
        echo 'Erro ao buscar categoria.<br>'.$ex;
      }
    }

    public function deletarCategoria($id) {
      try {
        $stat = $this->conexao->prepare("DELETE FROM categoria WHERE idCategoria = ?");
        $stat->bindValue(1, $id);
        $stat->execute();
        } catch (PDOException $ex) {
          echo 'Erro ao deletar categoria.<br>'.$ex;
        }
      }

      public function filtrarCategoria($query) {
        try {
          $stat = $this->conexao->query("SELECT * FROM categoria ".$query);
          $array = $stat->fetchAll(PDO::FETCH_CLASS,'Categoria');
          return $array;
        } catch (PDOException $ex) {
          echo 'Erro ao filtrar os resultados.<br>'.$ex;
        }
      }

      public function alterarCategoria($cat) {
        try {
          $stat = $this->conexao->prepare("UPDATE categoria SET nomeCategoria = ? WHERE idCategoria = ?");
          $stat->bindValue(1, $cat->nomeCategoria);
          $stat->bindValue(2, $cat->idCategoria);
          $stat->execute();
        } catch (PDOException $exc) {
          echo 'Erro ao alterar o categoria.<br>'.$exc;
        }
      }
    }
