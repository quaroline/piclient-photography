<?php
class Fotografia {

  private $codigo;
  private $evento;
  private $descricao;
  private $nome_imagem;
  private $tamanho_imagem;
  private $tipo_imagem;
  private $imagem;
  private $idCategoria;
  private $idUsuario;

  public function __construct() {}
  public function __destruct() {}

  public function __get($a) {
    return $this->$a;
  }

  public function __set($a,$v) {
    $this->$a = $v;
  }
}
