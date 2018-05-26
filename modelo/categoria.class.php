<?php
class Categoria {

  private $idCategoria;
  private $categoriaNome;

  public function __construct() {}
  public function __destruct() {}

  public function __get($a) {
    return $this->$a;
  }

  public function __set($a,$v) {
    $this->$a = $v;
  }

}
