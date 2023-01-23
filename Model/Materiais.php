<?php

namespace Model;

include_once "DB.php";

class Materiais extends DB
{
    public function cadMaterial(array $dados = null) : bool
    {
            self::conn()->beginTransaction();

            $sql = "INSERT INTO materiais (material, created_at, created_by) 
            VALUES (?,?,?)";
            $insert = self::conn()->prepare($sql);

            try {
                $insert->execute($dados);
                self::conn()->commit();
                return true;
            } catch (\Exception $e) {
                self::conn()->rollback();
                return false;
            }
    }

    // verificar se material ja existe na hora de cadastrar
    public function verifyMaterial(string $material = null) : bool
    {
        try {
        $sql = "SELECT material FROM materiais WHERE material = '$material'";
        $select = self::conn()->query($sql);
       
        if ($select->rowCount() > 0) {
            return false;
        } else {
            return true;
        }
        }catch(\PDOException $e) {
            echo 'Erro: ', $e->getMessage();
        }
    }

     // verificar se material ja existe na hora de editar
     public function verifyMaterialEdit(string $material = null) : bool
     {
         try {
         $sql = "SELECT material FROM materiais WHERE material = '$material'";
         $select = self::conn()->query($sql);
        
         if ($select->rowCount() >= 1) {
             return false;
         } else {
             return true;
         }
         }catch(\PDOException $e) {
             echo 'Erro: ', $e->getMessage();
         }
     }

    // listar materiais
    public function listarMateriais() : array
    {
        try {
        $b = self::conn()->query("SELECT * FROM materiais");
        return $b->fetchAll(\PDO::FETCH_OBJ);
        }catch(\Exception $e) {
            echo 'Erro ao listar';
        }
    }

     // função para pegar o usuario pelo id
    public function pegarMaterialCd(int $cd = null) : object
     {
         if ($cd != null) {
             try {
             $pegar = self::conn()->prepare("SELECT * FROM materiais WHERE id_material = :cd");
             $pegar->bindParam(':cd', $cd);
             $pegar->execute();
             return $pegar->fetchObject();
             }catch(\Exception $e) {
            	echo '<meta HTTP-EQUIV="Refresh" CONTENT="0; URL=?p=dashboard">';
             }
         }
    }

    // editar materiais
    public function editMaterial(array $dados) : bool
    {
        if($dados != null) {
            self::conn()->beginTransaction();
            try {
            $up = self::conn()->prepare("UPDATE materiais SET 
            material=?,
            updated_at=?,
            updated_by=?
             WHERE id_material=?");
            //  var_dump($up);exit;
            $up->execute($dados);
            self::conn()->commit();
            return true;
            }catch(\PDOException $e) {
                // echo $e->getMessage();
                self::conn()->rollback();
                return false;
            }
        }
    }

      // deletar material pelo id
      public function delMaterial(int $cd = null) : bool
      {
         if ($cd != null) {
             try{
             $del = self::conn()->prepare("DELETE FROM materiais WHERE id_material = :cd");
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