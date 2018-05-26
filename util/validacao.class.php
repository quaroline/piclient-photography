<?php
class Validacao {
  public static function validarCategoria($nomeCategoria):Int{
    $x = "/^[A-zÀ-ú]{2,30} ?[A-zÀ-ú]{1,30} ?[A-zÀ-ú]{2,30}$/";
    return preg_match($x, $nomeCategoria);
  }
  public static function validarNomeUsuario($nome):Int{
    $x = "/^[A-zÀ-ú]{2,30} ?[A-zÀ-ú]{1,30} ?[A-zÀ-ú]{1,30} ?[A-zÀ-ú]{1,30} ?[A-zÀ-ú]{1,30}$/";
    return preg_match($x, $nome);
  }
  public static function validarTelefone($telefone):Int{
    $x = "/\(?\d{2}\)?[\s-]?\d{4,5}-?\d{4}$/";
    return preg_match($x, $telefone);
  }
  public static function validarUsuario($usuario):Int{
    $x = "/^[\dA-z]{2,30}$/";
    return preg_match($x, $usuario);
  }
}
