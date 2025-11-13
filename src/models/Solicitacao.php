<?php

namespace Src\models;

use Src\database\MySQL;
use RuntimeException;


class Solicitacao{
    private int $idSolicitacao;
    private string $empresa;
    private string $areaAtuacao;
    private string $tipoEstagio;
    private ?int $carga_horaria_semanal;
    private string $turno;
    private ?string $obs;
    private int $idAluno;
    private String $data;
    private string $status;

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
    public function getData():String{
        return $this->data;
    }
    public function getStatus():String{
        return $this->status;
    }

    public function setIdSolicitacao($idSolicitacao){
        $this->idSolicitacao = $idSolicitacao;
    }
    public function setTurno($turno){
        $this->turno = $turno;
    }
    public function setObs(?string $obs){
        $this->obs = $obs;
    }

    public function setCargaHorariaSemanal(?int $carga_horaria_semanal){
        $this->carga_horaria_semanal = $carga_horaria_semanal;
    }
    public function setData($data){
        $this->data = $data;
    }
    public function setStatus($status){
        $this->status = $status;
    }     

    public function cadastrar(): int{
        $conn = new MySQL();
        $carga_horaria_semanal = $this->carga_horaria_semanal ?? 'NULL';
        $obs = $this->obs ?? 'NULL';   
        $sql = "INSERT INTO solicitacao(empresa, areaAtuacao, tipoEstagio, carga_horaria_semanal, turno, idAluno, obs) 
                VALUES('{$this->empresa}', '{$this->areaAtuacao}', '{$this->tipoEstagio}', {$carga_horaria_semanal}, '{$this->turno}', {$this->idAluno}, {$obs})";
        $conn->executa($sql);
        return $conn->getUltimoIdInserido();
    }
    
    public static function relacionarProfessor(int $idProf, int $idSol, string $status /* 0 = recusada, 1 = aceita, 2 = pendente */):int{
        $conn = new MySQL();
        $sql = "INSERT INTO professor_solicitacao(idProfessor, idSolicitacao, status)
                VALUES({$idProf}, {$idSol}, '{$status}')";
        $conn->executa($sql);
        return $conn->getUltimoIdInserido();
    }
    public function verStatus(int $idProfessor): string {
    $conn = new MySQL();

    $sql = "SELECT idProfessor, status FROM professor_solicitacao 
            WHERE idSolicitacao = {$this->idSolicitacao}";
    $resultado = $conn->consulta($sql);

    if (empty($resultado)) {
        return "Pendente";
    }

    $statusProfessorAtual = null; // status do professor logado
    $algumAceitou = false;        // se outro professor aceitou
    $todosPendentes = true;       // se todos ainda estão pendentes

    foreach ($resultado as $r) {
        $status = (int)$r['status'];

        // Verifica se algum status é diferente de pendente
        if ($status !== 2) {
            $todosPendentes = false;
        }

        // Guarda o status do professor atual
        if ((int)$r['idProfessor'] === $idProfessor) {
            $statusProfessorAtual = $status;
        }

        // Verifica se algum outro professor aceitou
        if ((int)$r['idProfessor'] !== $idProfessor && $status === 1) {
            $algumAceitou = true;
        }
    }

    // Regras de decisão final
    if ($todosPendentes) {
        return "Pendente";
    }

    if ($statusProfessorAtual === 1) {
        return "Aceito";
    }

    if ($statusProfessorAtual === 0) {
        return "Recusado";
    }

    if ($algumAceitou) {
        return "Finalizado";
    }

    // Caso não caia em nenhum caso específico
    return "Pendente";
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
