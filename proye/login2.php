<?php

require "conexion.php";

$control=$_POST['ncontrol'];
$clave=$_POST['Clave'];
$clave=filter_var($clave, FILTER_SANITIZE_STRING);
$clave=hash('sha512',$clave);

$quert = "SELECT * FROM usuario WHERE num_control='$control' AND password='$clave'";
$ejecutar=mysqli_query($conexion,$quert);
$filas=mysqli_num_rows($ejecutar);
if($filas){
    header("Location: index.php");
}else{
    header("Location: Index.php?error=Usuario o clave incorrecta");
}

?>