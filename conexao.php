<?php

$servidor = "localhost";
$usuario = "root";
$senha = "";
$dbname = "sf_system";


$conn = mysqli_connect($servidor, $usuario, $senha, $dbname);
mysqli_set_charset($conn,"utf8");

if (!$conn){
    die("Falha na conexão: " . mysqli_connect_error());

}else{
    //echo "Conexão realizada com sucesso";
}



?>