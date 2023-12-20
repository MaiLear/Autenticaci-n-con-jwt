<?php

use LoginConJwt\Backend\Core\Authenticacion;


if(isset($_POST['email'])){
    include_once __DIR__ . '/../Backend/Core/index.php';
    $register = new Authenticacion();
    $msg = $register->store();

}


?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrate</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>
<body>
   <div class="container w-100 d-flex flex-column align-items-center justify-content-center" style="height: 100vh;">
   <h1><?php echo $msg["msg"] ?? ''  ?></h1>
    <div class="border-success bg-secondary w-50">
         <h1 class="h3 text-center text-light">Registrate</h1>
         <form action="register.php" method="post" class="form p-5">
         <label class="form-label d-block">Nombre
            <input class="form-control " type="text" name="name" id="">
         </label>
         <br>
        <label class="form-label d-block">Correo
             <input class="form-control " type="email" name="email" id="">
        </label>
        <br>
         <label class="form-label d-block">Contraseña
            <input class="form-control " type="password" name="password" id="">
         </label>
         <div class="d-grid">
            <input class="btn btn-primary mt-5" type="submit" value="Enviar">
         </div>
         </form>
    </div>
   </div>
</body>
</html>