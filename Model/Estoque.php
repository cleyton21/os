<?php

namespace Model;

include_once "DB.php";

class Estoque extends DB
{
    public function cadEstoque(array $dados = null, int $qtdUnit) : bool
    {
            self::conn()->beginTransaction();

            $sql = "INSERT INTO estoque (id_material, descricao, qtd, created_at, created_by) 
            VALUES ($dados[0], '$dados[1]', $qtdUnit, '$dados[3]', '$dados[4]')";
            $insert = self::conn()->prepare($sql);
            // var_dump($insert); exit;
            try {
                for ($i=0; $i < $dados[2]; $i++) {
                    // echo $i."<br>";
                    $insert->execute($dados);
                }
                // $insert->execute($daos);
                self::conn()->commit();
                return true;
            } catch (\Exception $e) {
                self::conn()->rollback();
                return false;
            }
    }

    // listar estoque
    public function listarEstoque() : array
    {
        try {
        $b = self::conn()->query("SELECT chamados.ticket, estoque.id_estoque, estoque.id_material, materiais.material, qtd, usado, estoque.descricao, estoque.created_by, estoque.created_at, estoque.updated_by, estoque.updated_at 
        FROM estoque 
        INNER JOIN materiais 
        ON estoque.id_material = materiais.id_material 
        LEFT JOIN chamados
        ON estoque.id_estoque = chamados.id_estoque
        ORDER BY estoque.id_estoque DESC
        ");
        return $b->fetchAll(\PDO::FETCH_OBJ);
        }catch(\Exception $e) {
            echo 'Erro ao listar';
        }
    }

     // listar estoque usado
     public function listarEstoqueUsado() : array
     {
         try {
         $b = self::conn()->query("SELECT id_estoque, estoque.id_material, materiais.material, qtd, usado, descricao, estoque.created_by, estoque.created_at, estoque.updated_by, estoque.updated_at 
         FROM estoque 
         INNER JOIN materiais 
         ON estoque.id_material = materiais.id_material 
         WHERE usado = 1
         ORDER BY estoque.id_estoque DESC
         ");
         return $b->fetchAll(\PDO::FETCH_OBJ);
         }catch(\Exception $e) {
             echo 'Erro ao listar';
         }
     }

     // listar estoque disponivel
     public function listarEstoqueDisponivel() : array
     {
         try {
         $b = self::conn()->query("SELECT id_estoque, estoque.id_material, materiais.material, qtd, usado, descricao, estoque.created_by, estoque.created_at, estoque.updated_by, estoque.updated_at 
         FROM estoque 
         INNER JOIN materiais 
         ON estoque.id_material = materiais.id_material 
         WHERE usado = 0
         ORDER BY estoque.id_estoque DESC
         ");
         return $b->fetchAll(\PDO::FETCH_OBJ);
         }catch(\Exception $e) {
             echo 'Erro ao listar';
         }
     }

     // listar estoque chamado
     public function listarEstoqueChamado() : array
     {
         try {
         $b = self::conn()->query("SELECT materiais.id_material, materiais.material, estoque.id_estoque, estoque.id_material, estoque.descricao FROM materiais
         INNER JOIN estoque ON materiais.id_material = estoque.id_material
         WHERE estoque.usado=0
         ORDER BY materiais.material, estoque.id_estoque DESC
         ");
         return $b->fetchAll(\PDO::FETCH_OBJ);
         }catch(\Exception $e) {
             echo 'Erro ao listar';
         }
     }

     // função para pegar o estoque pelo id
    public function pegarEstoqueCd(int $cd = null) : object
     {
         if ($cd != null) {
             try {
             $pegar = self::conn()->prepare("SELECT id_estoque, estoque.id_material, materiais.material, qtd, descricao, estoque.created_by, estoque.created_at 
             FROM estoque 
             INNER JOIN materiais 
             ON estoque.id_material = materiais.id_material
             WHERE id_estoque = :cd
             ");
             $pegar->bindParam(':cd', $cd);
             $pegar->execute();
             return $pegar->fetchObject();
             }catch(\Exception $e) {
            	echo '<meta HTTP-EQUIV="Refresh" CONTENT="0; URL=?p=dashboard">';
             }
         }
    }

    // editar estoque
    public function editEstoque(array $dados) : bool
    {
        if($dados != null) {
            self::conn()->beginTransaction();
            try {
            $up = self::conn()->prepare("UPDATE estoque SET 
            id_material=?,
            descricao=?,
            updated_at=?,
            updated_by=?
             WHERE id_estoque=?");
            //  var_dump($up);exit;
            $up->execute($dados);
            self::conn()->commit();
            return true;
            }catch(\PDOException $e) {
                echo $e->getMessage();exit;
                self::conn()->rollback();
                return false;
            }
        }
    }

      // deletar estoque pelo id
      public function delEstoque(int $cd = null) : bool
      {
         if ($cd != null) {
             try{
             $del = self::conn()->prepare("DELETE FROM estoque WHERE id_estoque = :cd");
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