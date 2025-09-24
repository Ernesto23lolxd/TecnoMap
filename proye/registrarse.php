<?php 

include "conexion.php";

$control=$_POST['ncontrol'];
$email=$_POST['email'];
$clave=$_POST['Clave'];

$clave=filter_var($clave, FILTER_SANITIZE_STRING);
$clave=hash('sha512',$clave);

$query="INSERT INTO usuario(num_control,email,password) VALUES('$control','$email','$clave')";

try {
    $ejecutar=mysqli_query($conexion,$query);
if($ejecutar){
    header("Location: Index.php?success=Cuenta creada correctamente");
}else{
    header("Location: Registrarse.php?error=Error al crear la cuenta");
}
} catch (Exception $e) {
    if ($e->getCode() == 1062) { // Código de error para entrada duplicada
        echo "El usuario ya existe.";
    } else {
        echo "Error: " . $e->getMessage();
    }
}



?>