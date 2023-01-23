<?php

namespace Model;

include_once "DB.php";

// cad incicidente
class Incidentes extends DB
{
    public function cadIncidente(array $dados = null) : bool
    {
            self::conn()->beginTransaction();

            $sql = "INSERT INTO incidentes (incidente, dica, cor, created_at, created_by) 
            VALUES (?,?,?,?,?)";
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
    public function listarIncidente() : array
    {
        try {
        $b = self::conn()->query("SELECT * FROM incidentes       
        ");
        return $b->fetchAll(\PDO::FETCH_OBJ);
        }catch(\Exception $e) {
            echo 'Erro ao listar';
        }
    }

     // função para pegar o incidente pelo id
    public function pegarIncidenteCd(int $cd = null) : object
     {
         if ($cd != null) {
             try {
             $pegar = self::conn()->prepare("SELECT * FROM incidentes WHERE id_incidente = :cd");
             $pegar->bindParam(':cd', $cd);
             $pegar->execute();
             return $pegar->fetchObject();
             }catch(\Exception $e) {
            	echo '<meta HTTP-EQUIV="Refresh" CONTENT="0; URL=?p=home">';
             }
         }
    }

    // editar incidente
    public function editIncidente(array $dados) : bool
    {
        if($dados != null) {
            self::conn()->beginTransaction();
            try {
            $up = self::conn()->prepare("UPDATE incidentes SET 
            incidente=?,
            dica=?,
            cor=?,
            updated_at=?,
            updated_by=?
             WHERE id_incidente=?");
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

    // atualizar ip required
    public function editIncidenteIpRequired(array $dados) : bool
    {
        if($dados != null) {
            self::conn()->beginTransaction();
            try {
            $up = self::conn()->prepare("UPDATE incidentes SET 
            ip=?
            WHERE id_incidente=?");
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

    // atualizar equipamento required
    public function editIncidenteEquipamentoRequired(array $dados) : bool
    {
        if($dados != null) {
            self::conn()->beginTransaction();
            try {
            $up = self::conn()->prepare("UPDATE incidentes SET 
            equipamento=?
            WHERE id_incidente=?");
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

      // deletar incidente pelo id
      public function delIncidente(int $cd = null) : bool
      {
         if ($cd != null) {
             try{
             $del = self::conn()->prepare("DELETE FROM incidentes WHERE id_incidente = :cd");
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