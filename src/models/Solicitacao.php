<?php

namespace Src\models;

use Src\database\MySQL;
use RuntimeException;


class Solicitacao{
    private $idSolicitacao;
    private $empresa;
    private $areaAtuacao;
    private $tipoEstagio;
    private $carga_horaria_semanal;
    private $turno;
    private $obs;
    private $idAluno;

    public function __construct($empresa, $areaAtuacao, $tipoEstagio, $idAluno){
        $this->empresa = $empresa;
        $this->areaAtuacao = $areaAtuacao;
        $this->tipoEstagio = $tipoEstagio;
        $this->idAluno = $idAluno;
    }

    public function getIdSolicitacao(){
        return $this->idSolicitacao;
    }   
    public function getEmpresa(){
        return $this->empresa;
    }
    public function getAreaAtuacao(){
        return $this->areaAtuacao;
    }
    public function getTipoEstagio(){
        return $this->tipoEstagio;
    }
    public function getCargaHorariaSemanal(){
        return $this->carga_horaria_semanal;
    }
    public function getTurno(){
        return $this->turno;
    }
    public function getObs(){
        return $this->obs;
    }
    public function getIdAluno(){
        return $this->idAluno;
    }

    public function setIdSolicitacao($idSolicitacao){
        $this->idSolicitacao = $idSolicitacao;
    }
    public function setTurno($turno){
        $this->turno = $turno;
    }
    public function setObs($obs){
        $this->obs = $obs;
    }

    public function cadastrar(): int{
        $conn = new MySQL();     
        $sql = "INSERT INTO solicitacao(empresa, areaAtuacao, tipoEstagio, carga_horaria_semanal, turno, obs, idAluno) 
                VALUES('{$this->empresa}', '{$this->areaAtuacao}', '{$this->tipoEstagio}', {$this->carga_horaria_semanal}, '{$this->turno}', '{$this->obs}', {$this->idAluno})";
        $conn->executa($sql);
        return $conn->getUltimoIdInserido();
    }

    public function delete(): void{
        $conn = new MySQL();
        $sql = "DELETE FROM solicitacao WHERE idSolicitacao = {$this->idSolicitacao}";
        $conn->executa($sql);
    }

    public function atualizar(): bool{
        $conn = new MySQL();
        $sql = "UPDATE solicitacao SET 
                empresa = '{$this->empresa}', 
                areaAtuacao = '{$this->areaAtuacao}', 
                tipoEstagio = '{$this->tipoEstagio}', 
                carga_horaria_semanal = {$this->carga_horaria_semanal}, 
                turno = '{$this->turno}', 
                obs = '{$this->obs}', 
                idAluno = {$this->idAluno} 
                WHERE idSolicitacao = {$this->idSolicitacao}";
        return $conn->executa($sql);
    }

}