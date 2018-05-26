<?php
require_once "conexaobanco.class.php";

class UsuarioDAO {
  private $conexao = null;

  public function __construct() {
    $this->conexao = ConexaoBanco::getInstance();
  }

  public function __destruct() {}

    public function cadastrarUsuario($user) {
      try {
        $stat = $this->conexao->prepare("INSERT INTO usuario(idUsuario, login, senha, tipo, nome, telefone, email, endereco) VALUES (NULL,?,?,?,?,?,?,?);");
        $stat->bindValue(1,$user->login);
        $stat->bindValue(2,$user->senha);
        $stat->bindValue(3,$user->tipo);
        $stat->bindValue(4,$user->nome);
        $stat->bindValue(5,$user->telefone);
        $stat->bindValue(6,$user->email);
        $stat->bindValue(7,$user->endereco);
        $stat->execute();
        $this->conexao = null;
      } catch (PDOException $ex) {
        echo "Erro ao efetuar cadastro de usuário.<br>".$ex;
      }
    }

    public function buscarUsuario() {
      try{
        $stat = $this->conexao->query("SELECT * FROM USUARIO");
        $array = $stat->fetchAll(PDO::FETCH_CLASS,'Usuario');
        return $array;
      } catch (PDOException $ex) {
        echo 'Erro ao buscar usuário.<br>'.$ex;
      }
    }

    public function deletarUsuario($id) {
      try {
        $stat = $this->conexao->prepare("DELETE FROM usuario WHERE idUsuario = ?");
        $stat->bindValue(1, $id);
        $stat->execute();
        } catch (PDOException $ex) {
          echo 'Erro ao deletar usuário.<br>'.$ex;
        }
      }

      public function filtrarUsuario($query) {
        try {
          $stat = $this->conexao->query("SELECT * FROM usuario ".$query);
          $array = $stat->fetchAll(PDO::FETCH_CLASS,'Usuario');
          return $array;
        } catch (PDOException $ex) {
          echo 'Erro ao filtrar os resultados.<br>'.$ex;
        }
      }

      public function alterarUsuario($alt) {
        try {
          $stat = $this->conexao->prepare("UPDATE usuario SET login = ?, senha = ?, tipo = ?, nome = ?, telefone = ?, email = ?, endereco = ? WHERE idUsuario = ?");
          $stat->bindValue(1,$alt->login);
          $stat->bindValue(2,$alt->senha);
          $stat->bindValue(3,$alt->tipo);
          $stat->bindValue(4,$alt->nome);
          $stat->bindValue(5,$alt->telefone);
          $stat->bindValue(6,$alt->email);
          $stat->bindValue(7,$alt->endereco);
          $stat->bindValue(8,$alt->idUsuario);
          $stat->execute();
        } catch (PDOException $exc) {
          echo 'Erro ao alterar o usuário.<br>'.$exc;
        }
      }

      public function verificarUsuario($user) {
        try {
          $stat = $this->conexao->query("SELECT * FROM usuario WHERE login='$user->login' AND senha='$user->senha' AND tipo='$user->tipo'");
          $usuario = null;
          $usuario = $stat->fetchObject('Usuario');
          return $usuario;
        } catch (PDOException $ex) {
          echo 'Erro na verificação do usuário.<br>'.$ex;
        }
      }

      public function gerarJSON($query) {
        try {
          $stat = $this->conexao->query("SELECT * FROM usuario ".$query);
          return json_encode($stat->fetchAll(PDO::FETCH_ASSOC));
        } catch (PDOException $exc) {
          echo 'Erro ao gerar JSON de usuários.<br>'.$exc;
        }
      }
    }
