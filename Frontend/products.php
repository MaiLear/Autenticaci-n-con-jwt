<?php
use LoginConJwt\Backend\Core\Authenticacion;
if(isset($_GET["user"])){
    include_once __DIR__ . '/../Backend/Core/index.php';
    $user = json_decode($_GET["user"]);
    $token =$user->token;
    $login = new Authenticacion();
    $response = $login->validateToken($token);

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
    <title>Products</title>
</head>
<body>
    <h1>Este archivo solo lo deberian ver lo usuarios con el token</h1>
</body>
</html>