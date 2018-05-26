<?php
class Usuario {

  private $nome;
  private $telefone;
  private $email;
  private $endereco;
  private $idUsuario;
  private $login;
  private $senha;
  private $tipo;

  public function __construct() {}
  public function __destruct() {}

  public function __get($a) {
    return $this->$a;
  }

  public function __set($a,$v) {
    $this->$a = $v;
  }

  public function __toString() {
    return nl2br("Nome: $this->nome
                  Telefone: $this->telefone
                  E-mail: $this->email
                  Endereço: $this->endereco

                  Login: $this->login
                  Senha: $this->senha
                  Tipo de conta: $this->tipo");
  }
}
