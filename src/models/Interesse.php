<?php

namespace Src\models;

use Src\database\MySQL;
use RuntimeException;


class Interesse{
    private int $idInteresse;
    private string $descricao;

    public function __construct($descricao){
        $this->descricao = $descricao;
    }

    public function  setIdInteresse(int $idInteresse){
        $this->idInteresse = $idInteresse;
    }

    public function getIdInteresse(): int{
        return $this->idInteresse;
    }

    public function getDescricao(): string{
        return $this->descricao;
    }

    public static function listarTodos(): array{
        $conn = new MySQL();
        $sql = "SELECT idInteresse, descricao FROM interesse";
        $resultado = $conn->consulta($sql);
        $interesses = [];
        foreach($resultado as $r){
            $interesse = new Interesse($r['descricao']);
            $interesse->setIdInteresse($r['idInteresse']);
            $interesses[] = $interesse;
        }
        return $interesses;
    }

    public static function acharInteresse(int $idInteresse): ?self{
        $conn = new MySQL();
        $sql = "SELECT idInteresse, descricao FROM interesse";
        $r = $conn->consulta($sql);
        $interesse = new Interesse($r[0]['descricao']);
        $interesse->setIdInteresse($idInteresse);
        return $interesse;
    }

    public function cadastrar(): int{
        $conn = new MySQL();     
        $sql = "INSERT INTO interesse(descricao) VALUES('{$this->descricao}')";
        $conn->executa($sql);
        return $conn->getUltimoIdInserido();
    }

    
}