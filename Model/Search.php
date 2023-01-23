<?php

namespace Model;

include_once "DB.php";

class Search extends DB
{

    // listar usuarios
    public function listarUsuarios($pesquisar) : array
    {
        try {
        $b = self::conn()->query("SELECT id_user, user, postograd FROM user
        WHERE user LIKE '%$pesquisar%' OR postograd LIKE '%$pesquisar%'
        ");
        return $b->fetchAll(\PDO::FETCH_OBJ);
        }catch(\Exception $e) {
            echo 'Erro ao listar';
        }
    }

    public function listarSecao($pesquisar) : array
    {
        try {
        $b = self::conn()->query("SELECT id_secao, secao FROM secao
        WHERE secao LIKE '%$pesquisar%'
        ");
        return $b->fetchAll(\PDO::FETCH_OBJ);
        }catch(\Exception $e) {
            echo 'Erro ao listar';
        }
    }

    public function listarEquipamento($pesquisar) : array
    {
        try {
        $b = self::conn()->query("SELECT id_equipamento, nome, equipamento FROM equipamentos
        WHERE nome LIKE '%$pesquisar%' OR equipamento LIKE '%$pesquisar%'
        ");
        return $b->fetchAll(\PDO::FETCH_OBJ);
        }catch(\Exception $e) {
            echo 'Erro ao listar';
        }
    }

    public function listarMaterial($pesquisar) : array
    {
        try {
        $b = self::conn()->query("SELECT id_material, material FROM materiais
        WHERE material LIKE '%$pesquisar%'
        ");
        return $b->fetchAll(\PDO::FETCH_OBJ);
        }catch(\Exception $e) {
            echo 'Erro ao listar';
        }
    }

    public function listarEstoque($pesquisar) : array
    {
        try {
        $b = self::conn()->query("SELECT id_estoque, descricao FROM estoque
        WHERE descricao LIKE '%$pesquisar%'
        ");
        return $b->fetchAll(\PDO::FETCH_OBJ);
        }catch(\Exception $e) {
            echo 'Erro ao listar';
        }
    }

    public function listarIncidentes($pesquisar) : array
    {
        try {
        $b = self::conn()->query("SELECT id_incidente, incidente FROM incidentes
        WHERE incidente LIKE '%$pesquisar%'
        ");
        return $b->fetchAll(\PDO::FETCH_OBJ);
        }catch(\Exception $e) {
            echo 'Erro ao listar';
        }
    }

    public function listarChamadosPrioridade($pesquisar) : array
    {
        try {
        $b = self::conn()->query("SELECT id_chamado, ticket, prioridade FROM chamados
        WHERE prioridade LIKE '%$pesquisar%'
        ");
        return $b->fetchAll(\PDO::FETCH_OBJ);
        }catch(\Exception $e) {
            echo 'Erro ao listar';
        }
    }

    public function listarChamadosDescricao($pesquisar) : array
    {
        try {
        $b = self::conn()->query("SELECT id_chamado, ticket, descricao FROM chamados
        WHERE descricao LIKE '%$pesquisar%'
        ");
        return $b->fetchAll(\PDO::FETCH_OBJ);
        }catch(\Exception $e) {
            echo 'Erro ao listar';
        }
    }

    public function listarChamadosSolicitante($pesquisar) : array
    {
        try {
        $b = self::conn()->query("SELECT id_chamado, ticket, solicitante FROM chamados
        WHERE solicitante LIKE '%$pesquisar%'
        ");
        return $b->fetchAll(\PDO::FETCH_OBJ);
        }catch(\Exception $e) {
            echo 'Erro ao listar';
        }
    }

    public function listarChamadosStatus($pesquisar) : array
    {
        try {
        $b = self::conn()->query("SELECT id_chamado, ticket, status FROM chamados
        WHERE status LIKE '%$pesquisar%'
        ");
        return $b->fetchAll(\PDO::FETCH_OBJ);
        }catch(\Exception $e) {
            echo 'Erro ao listar';
        }
    }

    public function listarChamadosTecnico($pesquisar) : array
    {
        try {
        $b = self::conn()->query("SELECT id_chamado, ticket, tecnico FROM chamados
        WHERE tecnico LIKE '%$pesquisar%'
        ");
        return $b->fetchAll(\PDO::FETCH_OBJ);
        }catch(\Exception $e) {
            echo 'Erro ao listar';
        }
    }

    public function listarChamadosIp($pesquisar) : array
    {
        try {
        $b = self::conn()->query("SELECT id_chamado, ticket, ip FROM chamados
        WHERE ip LIKE '%$pesquisar%'
        ");
        return $b->fetchAll(\PDO::FETCH_OBJ);
        }catch(\Exception $e) {
            echo 'Erro ao listar';
        }
    }

    public function listarChamadosMsg($pesquisar) : array
    {
        try {
        $b = self::conn()->query("SELECT chamados.id_chamado, ticket, mensagem FROM suporte_chamados
        INNER JOIN chamados
        ON chamados.id_chamado = suporte_chamados.id_chamado                
        WHERE mensagem LIKE '%$pesquisar%'
        ");
        return $b->fetchAll(\PDO::FETCH_OBJ);
        }catch(\Exception $e) {
            echo 'Erro ao listar';
        }
    }

}