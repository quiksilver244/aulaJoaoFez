<?php
require_once 'DataBase.php';
require_once 'Numero.php';
class NumeroDAO{
    private $pdo;
    private $erro;

    public function getErro(){
        return $this->erro;
    }

    public function __construct()
    {
        try {
            $this->pdo = (new DataBase())->connection();
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (\PDOException $e) {
            $this->erro = 'Erro ao conectar com o banco de dados: ' . $e->getMessage();
            die;
        }
    }



    public function insert(Numero $numero): Numero|bool
    {
        $stmt = $this->pdo->prepare("INSERT INTO numero (numero, fk_Rifa_id, fk_Pedido_id, creation_time, modification_time) VALUES (:numero, :fk_Rifa_id,:fk_Pedido_id,:creation_time,:modification_time)");
        $dados = [
            'numero'            => $numero->getNumero(),
            'fk_Rifa_id'        => $numero->getRifaId(),
            'fk_Pedido_id'      => $numero->getPedidoId(),
            'creation_time'     => $numero->getCreationTime(),
            'modification_time' => $numero->getModificationTime(),
        ];
        try {
            $stmt->execute($dados);
            return $this->selectByNum($this->pdo->lastInsertId());
        } catch (\PDOException $e) {
            $this->erro = 'Erro ao inserir numero: ' . $e->getMessage();
            return false;
        }
    }

    public function selectByNum($numero): Numero|bool
    {//
        $stmt = $this->pdo->prepare("SELECT * FROM `numero` WHERE numero.fk_Rifa_id = :fk_Rifa_id AND numero.fk_Pedido_id = :fk_Pedido_id AND numero.numero = :numero");
        try {
            if($stmt->execute(['numero'=>$numero])){
                $row = $stmt->fetch(PDO::FETCH_ASSOC);
                return (new Numero(true, $row['numero'], $row['fk_Rifa_id'], $row['fk_Pedido_id'], $row['creation_time'], $row['modification_time']));
            }
            return false;   

        } catch (\PDOException $e) {
            $this->erro = 'Erro ao selecionar numero: ' . $e->getMessage();
            return false;
        }
    }

    public function listarTodos(){
        $cmdSql = "SELECT * FROM numero";
        $cx = $this->pdo->prepare($cmdSql);
        $cx->execute();
        if($cx->rowCount() > 0){
            $cx->setFetchMode(PDO::FETCH_CLASS, 'Numero');
            return $cx->fetchAll();
        }
        return false;
    }

    public function select($filtro=""):array|bool{
        $cmdSql = 'SELECT * FROM numero WHERE  numero LIKE :numero OR fk_Rifa_id LIKE :fk_Rifa_id OR fk_Pedido_id LIKE :fk_Pedido_id OR creation_time LIKE :creation_time OR modification_time LIKE :modification_time';
        try{
            $cx = $this->pdo->prepare($cmdSql);
            $cx->bindValue(':numero',"%$filtro%");
            $cx->bindValue(':fk_Rifa_id',"%$filtro%");
            $cx->bindValue(':fk_Pedido_id',"%$filtro%");
            $cx->bindValue(':creation_time',"%$filtro%");
            $cx->bindValue(':modification_time',"%$filtro%");
            $cx->execute();
            $cx->setFetchMode(PDO::FETCH_CLASS, 'Numero');
            return $cx->fetchAll();
        }
        catch (\PDOException $e) {
            $this->erro = 'Erro ao selecionar numero: ' . $e->getMessage();
            return false;
        }
    }

    public function selectByNumero($numero="")
    {
        $stmt = $this->pdo->prepare("SELECT * FROM numero WHERE numero LIKE :numero");
        $numero = '%' . $numero . '%';
        try {
            $stmt->execute(['numero'=>$numero]);
            return $stmt->fetchAll(PDO::FETCH_CLASS,"Numero");
        } catch (PDOException $e) {
            throw new Exception('Erro ao selecionar Numero da rifa: ' . $e->getMessage());
        }
    }
      

    public function update(Numero $numero)
    {
        $stmt = $this->pdo->prepare("UPDATE numero SET numero = ?, fk_Rifa_id = ?, fk_Pedido_id = ?, creation_time = ?, modification_time = ? WHERE id = ?");
        $numero                 = $numero->getNumero();
        $fk_Rifa_id             = $numero->getRifaId();
        $fk_Pedido_id           = $numero->getPedidoId();
        $creation_time          = $numero->getCreationTime();
        $modification_time      = $numero->getModificationTime();
        try {
            $stmt->execute([$numero, $fk_Rifa_id, $fk_Pedido_id, $creation_time, $modification_time]);
            return $stmt->rowCount();
        } catch (PDOException $e) {
            throw new Exception('Erro ao atualizar numero: ' . $e->getMessage());
        }
    }

    public function deleteByNumero($numero)
    {
        $stmt = $this->pdo->prepare("DELETE FROM numero WHERE numero = ?");
        try {
            $stmt->execute([$numero]);
            return $stmt->rowCount();
        } catch (PDOException $e) {
            throw new Exception('Erro ao excluir numero: ' . $e->getMessage());
        }
    }

    public function __destruct()
    {
        $this->pdo = null;
    }
}