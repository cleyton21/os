<?php

namespace Model;

include_once "DB.php";

// cad deção
class Secao extends DB
{
    public function cadSecao(array $dados = null) : bool
    {
            self::conn()->beginTransaction();

            $sql = "INSERT INTO secao (secao, created_at, created_by) 
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

    // listar seções
    public function listarSecao() : array
    {
        try {
        $b = self::conn()->query("SELECT * FROM secao       
        ");
        return $b->fetchAll(\PDO::FETCH_OBJ);
        }catch(\Exception $e) {
            echo 'Erro ao listar';
        }
    }

     // verificar se seção ja existe na hora de cadastrar
     public function verifySecao(string $secao = null) : bool
     {
         try {
         $sql = "SELECT secao FROM secao WHERE secao = '$secao'";
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

      // verificar se a seção ja existe na hora de editar
      public function verifySecaoEdit(string $secao = null) : bool
      {
          try {
          $sql = "SELECT secao FROM secao WHERE secao = '$secao'";
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

     // função para pegar a seção pelo id
    public function pegarSecaoCd(int $cd = null) : object
     {
         if ($cd != null) {
             try {
             $pegar = self::conn()->prepare("SELECT * FROM secao WHERE id_secao = :cd");
             $pegar->bindParam(':cd', $cd);
             $pegar->execute();
             return $pegar->fetchObject();
             }catch(\Exception $e) {
            	echo '<meta HTTP-EQUIV="Refresh" CONTENT="0; URL=?p=home">';
             }
         }
    }

    // editar seção
    public function editSecao(array $dados) : bool
    {
        if($dados != null) {
            self::conn()->beginTransaction();
            try {
            $up = self::conn()->prepare("UPDATE secao SET 
            secao=?,
            updated_at=?,
            updated_by=?
             WHERE id_secao=?");
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

      // deletar seção pelo id
      public function delSecao(int $cd = null) : bool
      {
         if ($cd != null) {
             try{
             $del = self::conn()->prepare("DELETE FROM secao WHERE id_secao = :cd");
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