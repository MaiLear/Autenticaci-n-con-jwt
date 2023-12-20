<?php

namespace LoginConJwt\Backend\Core;

require __DIR__ . '/../../../vendor/autoload.php';
include_once __DIR__ . '/../Config/Conexion.php';

use LoginConJwt\Backend\Config\ConexionConfig;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

use Dotenv\Dotenv;
use PDOException;

$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();



class Authenticacion
{
    public $conexionBd;

    public function __construct()
    {
        $this->conexionBd = ConexionConfig::conexionBd();
    }

    public function store()
    {
        $conexion = $this->conexionBd["data"];
        if ($conexion) {
            try {
                $query = $conexion->prepare("INSERT INTO users (name,email,password) VALUES (:name,:email,:password)");
                $query->execute([
                    ":name" => $_REQUEST['name'],
                    ":email" => $_REQUEST['email'],
                    ":password" => password_hash($_REQUEST['password'], PASSWORD_DEFAULT)
                ]);
                return ["msg" => "Usuario creado satisfactoriamente", "status" => 201];
            } catch (\Throwable $th) {
                return ["msg" => $th->getMessage(), "status" => 500];
            }
        } else {
            return $conexion;
        }
    }


    public function authenticate()
    {
        $conexion = $this->conexionBd["data"];
        if ($conexion) {
            try {
                $query = $conexion->prepare("SELECT * FROM users WHERE email=:email");
                if ($query->execute([":email" => $_REQUEST['email'],])) {
                    $user = $query->fetch();
                    if (password_verify($_REQUEST['password'], $user['password'])) {
                        $payload = [
                            "exp" => strtotime("now") + 3600,
                            "data" => $user["id"]
                        ];
                        $jwt = JWT::encode($payload, $_ENV["SECRET_KEY"], "HS256");

                        $user = json_encode(["name" => $user["name"], "token" => $jwt]);
                        header("Location: http://localhost:8080/Aprendiendo-php/LoginConJwt/Frontend/index.php?user=$user");
                        exit;
                    } else {
                        return ["msg" => "Contraseña incorrecta", "status" => 500];
                    }
                } else {
                    return ["msg" => "Correo electronico no encontrado", "status" => 404];
                }
            } catch (\Throwable $th) {
                return ["msg" => $th->getMessage(), "status" => 500];
            }
        } else {
            return $conexion;
        }
    }

    public function getToken($token){
        try{
            $decoded = JWT::decode($token,new Key($_ENV["SECRET_KEY"],"HS256")); 
            return ["token"=>$decoded,"status"=>200];
        }catch(\Throwable $th){
            return ["msg" => $th->getMessage(),"status"=>401];
        }
    }


    public function validateToken($token)
    {
        $responseToken = $this->getToken($token);
        if($responseToken["status"] == 200){
            $conexion = $this->conexionBd["data"];
            if ($conexion) {
                try {
                    $query = $conexion->prepare("SELECT * FROM users WHERE id=:id");
                    $query->execute([":id" => $responseToken["token"]->data]);
                    $user = $query->fetch();
                    return $user
                    ? ["msg" => "Authorize", "status" => 201]
                    : ["msg" => "Unauthorize", "status" => 401];
                } catch (\Throwable $th) {
                    return ["msg" => $th->getMessage(), "status" => 500];
                }
            } else {
                return $conexion;
            }
        }
        else{
            return $responseToken;
        }
    }
}
