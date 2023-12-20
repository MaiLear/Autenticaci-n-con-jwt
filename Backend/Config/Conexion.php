<?php

namespace LoginConJwt\Backend\Config;

use PDO;
use PDOException;

    define("HOST_SS","localhost");
    define("DB_NAME","login");
    define("USER_SS","root");
    define("PASSWORD_SS","");



    class ConexionConfig{
        public static function conexionBd(){
            try{
                $conexion = new PDO("mysql:host=".HOST_SS.";dbname=".DB_NAME,USER_SS,PASSWORD_SS);
                $conexion->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
                $data = ["msg" => "Coneaxion exitosa","status" => 200,"data" => $conexion];
                return $data;
            }catch(PDOException $error){
                $data = ["msg" => "Fallo la conexion $error", "status" => 500,"data" => ''];
                return $data;

            }
        }

    }
    
