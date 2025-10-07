<?php

class Usuario{
    private int $idUsuario;
    private string $nome;
    private string $email;
    private string $senha;
    private string $foto_perfil;
    private string $data_hora_cadastro;

    public function __construct($idUsuario, $nome, $foto_perfil, $email, $senha,){
        $this->idUsuario = $idUsuario;
        $this->nome = $nome;
        $this->foto_perfil = $foto_perfil;
        $this->email = $email;
        $this->senha = $senha;
    }

    public static function autenticar($email, $senha): Usuario{
        $conn = new MySQL();
        $sql = "SELECT senha FROM usuario WHERE email={$email}";
        $result = $conn->consulta($sql);
        if(count($result) === 1 and password_verify($senha, $result[0])){
            return true;
        }
        return false;
    }

    
}