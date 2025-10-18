<?php

namespace Src\Models;

use Src\Database\MySQL;
use RuntimeException;


class Usuario{
    private int $idUsuario;
    private string $nome;
    private string $email;
    private string $senha;
    private ?string $foto_perfil = null;
    private string $data_hora_cadastro;

    public function __construct($nome, $foto_perfil, $email, $senha){
        $this->nome = $nome;
        $this->foto_perfil = $foto_perfil;
        $this->email = $email;
        $this->senha = $senha;
    }

    public function  setIdUsuario(int $idUsuario){
        $this->idUsuario = $idUsuario;
    }

    public static function validarEmail(string $email): bool{
        $email = filter_var($email, FILTER_SANITIZE_EMAIL);
        if (filter_var($email, FILTER_VALIDATE_EMAIL) != false){
            if(str_ends_with(strtolower($email), 'feliz.ifrs.edu.br')){
                $conn = new MySQL();
                $sql = "SELECT idUsuario WHERE email={$email}";
                $resultado = $conn->consulta($sql);
                return count($resultado) > 1 ? false : true;
            }   
        }
        return false;
    }

    public static function validarSenha($senha): bool{
        $regex = '/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d@$!%*?&]{8,}$/';
        return preg_match($regex, $senha) == 1;  # preg_match retorna 1 para correspondência e 0 para não correspondência.
    }

    public static function autenticar($email, $senha): bool{
        $conn = new MySQL();
        $sql = "SELECT senha FROM usuario WHERE email={$email}";
        $resultado = $conn->consulta($sql);
        if(count($resultado) === 1 and password_verify($senha, $resultado[0])){
            return true;
        }
        return false;
    }

    public function cadastrar(): int{
        $conn = new MySQL();
        self::validarEmail($this->email) ? null : throw new RuntimeException('Email inválido', 100);
        self::validarSenha($this->senha) ? null : throw new RuntimeException('Senha inválida', 101);
        $sql = "INSERT INTO usuario(nome, email, senha) VALUES({$this->nome}, {$this->email}, {$this->senha})";
        $conn->executa($sql);
        return $conn->getUltimoIdInserido();
    }

    
}