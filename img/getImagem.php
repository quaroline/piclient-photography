<?php
include_once 'dao/conexaobanco.class.php';
$result=mysqli_query($con,"SELECT * FROM PESSOA WHERE idFoto=$codigo");
$row=mysqli_fetch_object($result);
Header( "Content-type: image/gif");
echo $row->imagem;
?>
