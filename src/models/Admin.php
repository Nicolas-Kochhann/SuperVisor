<?php

namespace Src\models;

use Src\database\MySQL;

class Admin{
    
    public static function autenticar(string $email, string $senha): bool{
        $conn = new MySQL();
        $sql = "SELECT idAdmin, senha FROM admin WHERE email='{$email}'";
        $resultado = $conn->consulta($sql);
        if(count($resultado) === 1 and $senha === $resultado[0]['senha']){
            session_start();

            $_SESSION['idAdmin'] = $resultado[0]['idAdmin'];
            $_SESSION['email'] = $email;
            
            return true;
        }
        return false;
    }

}
