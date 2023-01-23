<?php

namespace Model;

include_once "DB.php";

// cad equipamento
class Equipamentos extends DB
{
    public function cadEquipamento(array $dados = null) : bool
    {
            self::conn()->beginTransaction();

            $sql = "INSERT INTO equipamentos (id_secao, nome, equipamento, created_at, created_by) 
            VALUES (?,?,?,?,?)";
            $insert = self::conn()->prepare($sql);
            // var_dump($insert); exit;
            try {
                $insert->execute($dados);
                self::conn()->commit();
                return true;
            } catch (\Exception $e) {
                self::conn()->rollback();
                return false;
            }
    }

    // listar equipamentos
    public function listarEquipamentos() : array
    {
        try {
        $b = self::conn()->query("SELECT chamados.id_chamado, equipamentos.id_equipamento, equipamentos.id_secao, nome, equipamentos.equipamento, equipamentos.created_at, equipamentos.created_by, equipamentos.updated_at, equipamentos.updated_by, secao 
        FROM equipamentos 
        INNER JOIN secao 
        ON equipamentos.id_secao = secao.id_secao
        LEFT JOIN chamados
        ON chamados.id_equipamento = equipamentos.id_equipamento  
        ");
        return $b->fetchAll(\PDO::FETCH_OBJ);
        }catch(\Exception $e) {
            echo 'Erro ao listar';
        }
    }

     // verificar se seção ja existe na hora de cadastrar
    //  public function verifySecao(string $secao = null) : bool
    //  {
    //      try {
    //      $sql = "SELECT secao FROM secao WHERE secao = '$secao'";
    //      $select = self::conn()->query($sql);
        
    //      if ($select->rowCount() > 0) {
    //          return false;
    //      } else {
    //          return true;
    //      }
    //      }catch(\PDOException $e) {
    //          echo 'Erro: ', $e->getMessage();
    //      }
    //  }

     // função para pegar o equipamento pelo id
    public function pegarEquipamentoCd(int $cd = null) : object
     {
         if ($cd != null) {
             try {
             $pegar = self::conn()->prepare("SELECT id_equipamento, equipamentos.id_secao, equipamentos.nome, equipamento, equipamentos.created_at, equipamentos.created_by, equipamentos.updated_at, equipamentos.updated_by, secao 
             FROM equipamentos 
             INNER JOIN secao 
             ON equipamentos.id_secao = secao.id_secao 
             WHERE equipamentos.id_equipamento = :cd
             ");
             $pegar->bindParam(':cd', $cd);
             $pegar->execute();
             return $pegar->fetchObject();
             }catch(\Exception $e) {
            	echo '<meta HTTP-EQUIV="Refresh" CONTENT="0; URL=?p=home">';
             }
         }
    }


     // função para pegar o equipamento para o chamado
     public function pegarEquipamentos(int $cd = null) : array
     {
         if ($cd != null) {
             try {
             $pegar = self::conn()->query("SELECT chamados.id_chamado, chamados.id_user, secao.secao, equipamentos.id_equipamento, equipamentos.nome FROM chamados
             INNER JOIN user 
             ON chamados.id_user = user.id_user
             INNER JOIN secao
             ON user.id_user = secao.id_user
             INNER JOIN equipamentos
             ON secao.id_secao = equipamentos.id_secao
             WHERE chamados.id_chamado = '$cd'
             ");
            //  $pegar->bindParam(':cd', $cd);
            //  $pegar->execute();
             return $pegar->fetchAll(\PDO::FETCH_OBJ);
             }catch(\Exception $e) {
                 echo $e;
            	echo '<meta HTTP-EQUIV="Refresh" CONTENT="0; URL=?p=home">';
             }
         }
    }

    // editar equipamento
    public function editEquipamento(array $dados) : bool
    {
        if($dados != null) {
            self::conn()->beginTransaction();
            try {
            $up = self::conn()->prepare("UPDATE equipamentos SET 
            id_secao=?,
            nome=?,
            equipamento=?,
            updated_at=?,
            updated_by=?
             WHERE id_equipamento=?");
            $up->execute($dados);
            // var_dump($up->execute($dados));exit;
            self::conn()->commit();
            return true;
            }catch(\PDOException $e) {
                // echo $e->getMessage();
                self::conn()->rollback();
                return false;
            }
        }
    }

      // deletar equipamento pelo id
      public function delEquipamento(int $cd = null) : bool
      {
         if ($cd != null) {
             try{
             $del = self::conn()->prepare("DELETE FROM equipamentos WHERE id_equipamento = :cd");
             $del->bindParam(':cd', $cd);
             $del->execute();
             return true;
             } catch(\PDOException $e) {
                //  echo 'Erro ao excluir!!!';
                 return false;
             }
         }
     }
}