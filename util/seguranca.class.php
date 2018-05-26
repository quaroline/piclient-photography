<?php
class Seguranca {

  public static function criptografarSenha($v) {
    return md5('Pic'.$v.'Nic');
  }
}
