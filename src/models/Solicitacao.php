<?php

namespace Src\models;

use Src\database\MySQL;
use RuntimeException;


class Solicitacao{
    private int $idSolicitacao;
    private string $empresa;
    private string $areaAtuacao;
    private string $tipoEstagio;
    private int $carga_horaria_semanal;
    private string $turno;
    private string $obs;
    private int $idAluno;


    public function __construct($empresa, $areaAtuacao, $tipoEstagio, $idAluno){
        $this->empresa = $empresa;
        $this->areaAtuacao = $areaAtuacao;
        $this->tipoEstagio = $tipoEstagio;
        $this->idAluno = $idAluno;
    }

    public function getIdSolicitacao():int{
        return $this->idSolicitacao;
    }   
    public function getEmpresa():string{
        return $this->empresa;
    }
    public function getAreaAtuacao():string{
        return $this->areaAtuacao;
    }
    public function getTipoEstagio():string{
        return $this->tipoEstagio;
    }
    public function getCargaHorariaSemanal():int{
        return $this->carga_horaria_semanal;
    }
    public function getTurno():string{
        return $this->turno;
    }
    public function getObs():string{
        return $this->obs;
    }
    public function getIdAluno():int{
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

    public function setCargaHorariaSemanal($carga_horaria_semanal){
        $this->carga_horaria_semanal = $carga_horaria_semanal;
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