<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="CSS/Styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>Registrarse</title>
    <script src="js/script.js"></script>
</head>
<body>
    <div class="contenedor">
        <h1><ins>Registrarse</ins></h1>
        <br>
        <form action="registrarse.php" method="POST" id="form">

            <?php if (isset($_GET['error'])) { ?>
                <p class="error"> <?php echo $_GET['error']; ?></p>
            <?php }?>
            <br>
            <?php if (isset($_GET['success'])) { ?>
                <p class="success"> <?php echo $_GET['success']; ?></p>
            <?php }?>
            <br>
            <label for="">
                <i class="fa-solid fa-users"></i>
                Numero de control
            </label>
            <input type="text" placeholder="Ingrese su numero de control" name="ncontrol"  autocomplete="off" id="ncontrol">
            
            <label for="">
            <i class="fa-solid fa-user"></i>
                Correo
            </label>
            <input type="mail" placeholder="Ingrese su correo" name="email"  autocomplete="off" id="email">

            <label for="">
            <i class="fa-solid fa-key"></i>
                Clave
            </label>
            <input type="password" placeholder="Ingrese Clave" name="Clave" id="Clave" >
            <label for="">
            <i class="fa-solid fa-key"></i>
                Repetir Clave
            </label>
            <input type="password" placeholder="Repita Clave" name="RClave" id="RClave" >

            <input type="submit" class="button" value="Registrarse">
            <a href="login.php" class="Boton_Ingresar">
                Ingresar
            </a>

        </form>
    </div>
</body>
</html>