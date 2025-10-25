<?php

namespace Src\models;

use Src\database\MySQL;
use RuntimeException;


class Usuario{
    private int $idUsuario;
    private string $nome;
    private string $email;
    private string $senha;
    private string $tipo;
    private ?string $foto_perfil = null;
    private string $data_hora_cadastro;
    private bool $disponivel;
    private int $status; // 0 - ativo / 1 - pendente / 2 - inativo

    public function __construct($nome, $foto_perfil, $email, $senha){
        $this->nome = $nome;
        $this->foto_perfil = $foto_perfil;
        $this->email = $email;
        $this->senha = $senha;
    }

    public function  setIdUsuario(int $idUsuario){
        $this->idUsuario = $idUsuario;
    }

    public function setDisponivel(bool $disponivel){
        $this->disponivel = $disponivel;
    }

    public static function validarEmail(string $email): bool{
        $email = filter_var($email, FILTER_SANITIZE_EMAIL);
        if (filter_var($email, FILTER_VALIDATE_EMAIL) != false){
            if(str_ends_with(strtolower($email), 'feliz.ifrs.edu.br')){
                $conn = new MySQL();
                $sql = "SELECT idUsuario FROM usuario WHERE email='{$email}'";
                $resultado = $conn->consulta($sql);
                return count($resultado) === 0;
            }
            return false;
        }
        return false;
    }

    public static function acharUsuarioPeloEmail(string $email) : ?Usuario{
        $conn = new MySQL();
        $sql = "SELECT idUsuario, nome, imagem, senha FROM usuario WHERE email='{$email}'";
        $resultado = $conn->consulta($sql);
        if(count($resultado) === 1){
            $u = new Usuario($resultado[0]['nome'], $resultado[0]['imagem'], $email, $resultado[0]['senha']);
            $u->setIdUsuario($resultado[0]['idUsuario']);
            return $u;
        }
        return null;

    }
    
    public static function acharUsuario(int $idUsuario) : ?Usuario{
        $conn = new MySQL();
        $sql = "SELECT nome, imagem, email, senha FROM usuario WHERE idUsuario={$idUsuario}";
        $resultado = $conn->consulta($sql);
        if(count($resultado) === 1){
            $u = new Usuario($resultado[0]['nome'], $resultado[0]['imagem'], $resultado[0]['email'], $resultado[0]['senha']);
            $u->setIdUsuario($idUsuario);
            return $u;
        }
        return null;
    }


    public static function listarProfessores() : array{
        $conn = new MySQL();    
        $sql = "SELECT idUsuario, nome, imagem, email, senha, disponivel FROM usuario WHERE tipo='professor'";
        $resultado = $conn->consulta($sql);
        $professores = [];
        foreach($resultado as $r){
            $u = new Usuario($r['nome'], $r['imagem'], $r['email'], $r['senha']);
            $u->setIdUsuario($r['idUsuario']);
            $u->setDisponivel($r['disponivel']);
            $professores[] = $u;
        }
        return $professores;
    }

    public static function listarAlunos() : array{
        $conn = new MySQL();    
        $sql = "SELECT idUsuario, nome, imagem, email, senha, disponivel FROM usuario WHERE tipo='aluno'";
        $resultado = $conn->consulta($sql);
        $alunos = [];
        foreach($resultado as $r){
            $u = new Usuario($r['nome'], $r['imagem'], $r['email'], $r['senha']);
            $u->setIdUsuario($r['idUsuario']);
            $u->setDisponivel($r['disponivel']);
            $alunos[] = $u;
        }
        return $alunos;
    }

    public static function validarSenha(string $senha): bool{
        $regex = '/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d@$!%*?&]{8,}$/';
        return preg_match($regex, $senha) === 1;  # preg_match retorna 1 para correspondência e 0 para não correspondência.
    }

    public static function autenticar(string $email, string $senha): bool{
        $conn = new MySQL();
        $sql = "SELECT idUsuario,senha, tipo, disponivel, nome, imagem  FROM usuario WHERE email='{$email}'";
        $resultado = $conn->consulta($sql);
        if(count($resultado) === 1 and password_verify($senha, $resultado[0]['senha'])){
            session_start();

            $_SESSION['idUsuario'] = $resultado[0]['idUsuario'];
            $_SESSION['nome'] = $resultado[0]['nome'];
            $_SESSION['imagem'] = $resultado[0]['imagem'];
            $_SESSION['tipo'] = $resultado[0]['tipo'];
            $_SESSION['disponivel'] = $resultado[0]['disponivel'];
            $_SESSION['status'] = $resultado[0]['status'];

            return true;
        }
        return false;
    }

    public function cadastrar(): int{
        $conn = new MySQL();
        if(!self::validarEmail($this->email)){
            throw new RuntimeException('Email ou senha inválidos', 100);
        }
        if(!self::validarSenha($this->senha)){
            throw new RuntimeException('Email ou senha inválidos', 101);
        }
        if(str_ends_with($this->email , "@aluno.feliz.ifrs.edu.br")){
            $this->tipo = "aluno";
        }else if (str_ends_with($this->email, "@feliz.ifrs.edu.br")){
            $this->tipo = "professor";
        } else {
            throw new RuntimeException('Email ou senha inválidos', 102);
        }
        $this->status = 1;
        $sql = "INSERT INTO usuario(nome, email, senha, tipo, status) VALUES('{$this->nome}', '{$this->email}', '".password_hash($this->senha, PASSWORD_BCRYPT)."', '{$this->tipo}', '{$this->status}')";
        $conn->executa($sql);
        return $conn->getUltimoIdInserido();
    }

    public function atualizar(): bool{
        $conn = new MySQL();
        if(!self::validarEmail($this->email)){
            throw new RuntimeException('Email ou senha inválidos', 100);
        }
        if(!self::validarSenha($this->senha)){
            throw new RuntimeException('Email ou senha inválidos', 101);
        }
        if(str_ends_with($this->email , "@aluno.feliz.ifrs.edu.br")){
            $this->tipo = "aluno";
        }else if (str_ends_with($this->email, "@feliz.ifrs.edu.br")){
            $this->tipo = "professor";
        } else {
            throw new RuntimeException('Email ou senha inválidos', 102);
        }
        isset($_SESSION['status']) and $_SESSION['status'] == 0 ? $this->status = 0 : $this->status = 1;
        $sql = "UPDATE usuario SET nome='{$this->nome}', email='{$this->email}', senha='". password_hash($this->senha,  PASSWORD_BCRYPT) ."', tipo='{$this->tipo}', status={$this->status} WHERE idUsuario={$this->idUsuario}";
        return $conn->executa($sql);
    }

    public function cadastrarInteresses(array $interesses): void{
        $conn = new MySQL();
        foreach($interesses as $i){
            $sql = "INSERT INTO usuario_interesse(idUsuario, idInteresse) VALUES({$this->idUsuario}, {$i})";
            $conn->executa($sql);
        }
    }

    public function cadastrarDesinteresses(array $desinteresses): void{
        $conn = new MySQL();
        foreach($desinteresses as $i){
            $sql = "INSERT INTO usuario_desinteresse(idUsuario, idInteresse) VALUES({$this->idUsuario}, {$i})";
            $conn->executa($sql);
        }
    }

    public function acharInteresses(): array{
        $conn = new MySQL();
        $sql = "SELECT idInteresse FROM usuario_interesse WHERE idUsuario={$this->idUsuario}";
        $resultado = $conn->consulta($sql);
        $interesses = [];
        foreach($resultado as $r){
            $interesses[] = $r['idInteresse'];
        }
        return $interesses;
    }
    public function acharDesinteresses(): array{
        $conn = new MySQL();
        $sql = "SELECT idInteresse FROM usuario_desinteresse WHERE idUsuario={$this->idUsuario}";
        $resultado = $conn->consulta($sql);
        $desinteresses = [];
        foreach($resultado as $r){
            $desintereses[] = $r['idInteresse'];
        }
        return $desinteresses;
    }

    public function setStatus(int $status): void{
        $this->status = $status;
    }

    public function setTipo(string $tipo):void{
        $this->tipo = $tipo;
    }

    public function getNome(): string{
        return $this->nome;
    }
    public function getEmail(): string{
        return $this->email;
    }
    public function getSenha(): string{
        return $this->senha;
    }
    public function getFotoPerfil(): ?string{
        return $this->foto_perfil;
    }
    public function getIdUsuario(): int{
        return $this->idUsuario;
    }
    
}