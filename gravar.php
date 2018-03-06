<?php
if(isset($_SESSION['privateUser'])) {
	include_once 'modelo/usuario.class.php';
	$u = unserialize($_SESSION['privateUser']);
	if($u->tipo = 'Cliente') {
		header("location:dashboard.php");
	}

$imagem = $_FILES["imagem"];
$host = "localhost";
$username = "root";
$password = "";
$db = "piclient";

if($imagem != NULL) {
	$nomeFinal = time().'.jpg';
	if (move_uploaded_file($imagem['tmp_name'], $nomeFinal)) {
		$tamanhoImg = filesize($nomeFinal);
		$mysqliImg = addslashes(fread(fopen($nomeFinal, "r"), $tamanhoImg));
		$con = mysqli_connect($host,$username,$password,$db) or die("Impossível Conectar");
		@mysqli_select_db($con, $db) or die("Impossível Conectar");

		include_once 'modelo/fotografia.class.php';
		include_once 'dao/fotografiadao.class.php';

		mysqli_query($con,"INSERT INTO fotografia (foto) VALUES ('$mysqlImg');") or die("O sistema não foi capaz de executar a query");
		unlink($nomeFinal);
		header("location:dashboard.php");
	}
}
else {
	echo "Você não realizou o upload de forma satisfatória.";
}
}
?>
