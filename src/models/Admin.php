<?php

namespace Src\models;

use Src\database\MySQL;

class Admin{

    private string $email;
    private string $senha;

    public function __construct($email, $senha){
        $this->email = $email;
        $this->senha = $senha;
    }
    
    public static function autenticar(string $email, string $senha): bool{
        $conn = new MySQL();
        $sql = "SELECT idAdmin, senha FROM admin WHERE email='{$email}'";
        $resultado = $conn->consulta($sql);
        if(count($resultado) === 1 and password_verify($senha, $resultado[0]['senha'])){
            session_start();

            $_SESSION['idAdmin'] = $resultado[0]['idAdmin'];
            $_SESSION['email'] = $email;
            
            return true;
        }
        return false;
    }

    public function cadastrar(): int{
        $conn = new MySQL();
        $sql = "INSERT INTO admin(email, senha) VALUES('{$this->email}', '".password_hash($this->senha, PASSWORD_BCRYPT)."')";
        $conn->executa($sql);
        return $conn->getUltimoIdInserido();
    }

}
