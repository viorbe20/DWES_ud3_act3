<?php
/**
 * Ejercicio cookies. Ejercicio 1.
 * Formulario con usuario y contraseña y un botón de enviar. Al entrar aparece un hola mundo.
 * Debe contener un checkbox 'Recordar'. 
 * Si se marca, cuando volvamos a entrar debe ofrecer ese usuario y contraseña.
 */

$username = "";
$password = "";
$usernameError = "";
$passwordError = "";
$dataError = false;
$processForm = true;

  
//Función que limpia los datos del usuario.
function clearData($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
};

//Cargamos datos en variables
if (isset($_COOKIE['username&password'])) {
    $userData = explode("/", $_COOKIE['username&password']);
    $username = $userData[0];
    $password = $userData[1];
}

//Comprobaciones una vez hacemos click en enviar
if (isset($_POST['login'])) {

    //Comprobamos si los campos están vacíos
    if (empty($_POST["username"])) {
        $usernameError = "El usuario es obligatorio.";
        $dataError = true;
    } else {
        $username = clearData($_POST["username"]);
    }

    if (empty($_POST["password"])) {
        $passwordError = "La contraseña es obligatoria.";
        $dataError = true;
    } else {
        $password = clearData($_POST["password"]);
    }
    
    //Comprobamos si se ha marcado la opción recordar
    if ((isset($_POST['saveData']) =='on')) {
        $loginParts = $username."/".$password;

        //Si la cookie tiene valores se establece un valor más
        if (!isset($_COOKIE['username&password'])) {
            setcookie('username&password',$loginParts,time()+36000);
        }
    }else{
        if (isset($_COOKIE['username&password'])) {
            setcookie('username&password',"",time()-36000);
        }            
    }

    if (!$dataError) {
        $processForm = false;
        echo "<form action='' method='post'>
        <h1>Te has logueado correctamente.</h1><br>
        <input type='submit' name='logout' value='Salir'>
        </form>";

        //Permite desloguearse y volver a la pantalla inicial
        if (isset($_POST["logout"])) {
            $processForm = true;
        }
    }
}

if ($processForm) {
    ?>
    <form action="" method="post">
    <h1>Ejercicio 1. Cookies </h1>
    <p>Introduce un usuario y una contraseña.</p>
    <p>Haz click en "Recordar" si quieres que esos datos aparezcan la próxima vez que quieras entrar.</p>
    
    <input type="username" name="username" placeholder="Nombre usuario" value='<?php echo $username?>'>
    <span class='error'><?php echo $usernameError?></span>
    <br><br>

    <input type="password" name="password" placeholder="Contraseña" value='<?php echo $password?>'>
    <span class='error'><?php echo $passwordError?></span> 
    <br><br>
    
    <label for="">
        <input type="checkbox" name="saveData" id="">
        Recordar
    </label>
    <br><br>
    
    <input type="submit" name="login" value="Entrar">
</form>
<?php    
}
?>