<?php

namespace Repository;

use DB\MySQL;

class UsuariosRepository
{
    private object $MySQL;
    public const TABELA = 'usuarios';

    public function __construct()
    {
        $this->Mysql = new MySQL();
    }

    public function insertUser($login, $senha)
    {
        $consultaInsert = 'INSERT INTO '. self::TABELA . ' (login, senha) VALUES (:login, :senha)';
        $this->Mysql->getDb()->beginTransaction();
        $stmt = $this->Mysql->getDb()->prepare($consultaInsert);
        $stmt->bindParam(':login', $login);
        $stmt->bindParam(':senha', $senha);
        $stmt->execute();
        return $stmt->rowCount();
    }

    public function updateUser($id, $dados)
    {
        $consultaUpdate = 'UPDATE ' . self::TABELA . ' SET login = :login, senha = :senha WHERE id = :id';
        $this->Mysql->getDb()->beginTransaction();
        $stmt = $this->Mysql->getDb()->prepare($consultaUpdate);
        $stmt->bindParam(':login', $dados['login']);
        $stmt->bindParam(':senha', $dados['senha']);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->rowCount();
    }

    public function getMySQL()
    {
        return $this->Mysql;
    }
}