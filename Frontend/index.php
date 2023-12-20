<?php
use LoginConJwt\Backend\Core\Authenticacion;


    if(isset($_GET["user"])){     
        $user = json_decode($_GET["user"]);
        $login = new Authenticacion();
        $response= $login->validateToken($user->token);
        if($response["status"] != 201){
            header("Location: http://localhost:8080/Aprendiendo-php/LoginConJwt/Frontend/Errores/Unauthorized.php");
            exit;
        }
    }
    else{
        header("Location: http://localhost:8080/Aprendiendo-php/LoginConJwt/Frontend/Errores/Unauthorized.php");
        exit;
    }




?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>
<body>
    <h1 class="display-1"><?php echo $msg ?? '' ?></h1>
    <h1>Bienvenido <?php echo $user->name ?? '' ?></h1>
    <a class="btn btn-primary" href="http://localhost:8080/Aprendiendo-php/LoginConJwt/Frontend/products.php">Ir a la vista products</a>
</body>
</html>