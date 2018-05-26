<?php
  $conexao = mysqli_connect("localhost", "root", "");
  mysqli_set_charset($conexao,"utf8");

  if($conexao)
  {
  $baseSelecionada = mysqli_select_db($conexao, "piclient");
  if (!$baseSelecionada) {
      die ('Não foi possível conectar a base de dados: ' . mysql_error());
  } } else {
      die('Não conectado : ' . mysql_error());
  }

class ConexaoBanco extends PDO {

  private static $instance = null;

  public function __construct($dsn,$user,$pass) {
      parent::__construct($dsn,$user,$pass);
  }

  public static function getInstance() {
    if(!isset(self::$instance)) {
      try {
        self::$instance = new ConexaoBanco("mysql:dbname=piclient;host=localhost","root","",array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
      } catch(PDOException $e) {
        echo "Erro ao conectar!<br>".$e;
      }
    }
    return self::$instance;
  }
}
