<?php

namespace Model;

include_once "DB.php";

class Usuarios extends DB
{
    public function cadUsuarios(array $dados = null, $id_secao) : bool
    {
            try {

            self::conn()->beginTransaction();

            $sql = "INSERT INTO user (user, postograd, passwd, perfil, created_at, created_by) 
            VALUES (?,?,?,?,?,?)";
            $insert = self::conn()->prepare($sql);
            $insert->execute($dados);
            $id_user = self::conn()->lastInsertId(); //pega o id do usuario cadastrado

            $sel = self::conn()->query("SELECT id_user, secao FROM secao WHERE id_secao = '$id_secao'");
            $a = $sel->fetchObject();
            if($a->id_user != "" && $a->secao != ""){
                echo "<script>alert('Erro..Já existe um usuário cadastrado nesta seção...Tente novamente');</script>";
                return false;
                exit;
            }
            
            $up = self::conn()->prepare("UPDATE secao SET 
            id_user='$id_user'
            WHERE id_secao='$id_secao'");

                $up->execute();
                self::conn()->commit();
                return true;
            } catch (\Exception $e) {
                echo "<script>alert('Este usuário já está cadastrado em nosso sistema..Tente novamente');</script>";
                self::conn()->rollback();
                return false;
            }
    }

    // listar usuarios
    public function listarUsuarios() : array
    {
        try {
        $b = self::conn()->query("SELECT secao.secao, user.* 
        FROM user 
        LEFT JOIN secao 
        ON secao.id_user = user.id_user
        ORDER BY perfil, created_at DESC, updated_at DESC
        ");
        return $b->fetchAll(\PDO::FETCH_OBJ);
        }catch(\Exception $e) {
            echo 'Erro ao listar';
        }
    }

    // listar usuarios clientes
    public function ListarusuariosClientes() : array
    {
        try {
        $b = self::conn()->query("SELECT secao.secao, user.* 
        FROM user 
        LEFT JOIN secao 
        ON secao.id_user = user.id_user
        WHERE user.perfil=3
        ORDER BY perfil, created_at DESC, updated_at DESC
        ");
        return $b->fetchAll(\PDO::FETCH_OBJ);
        }catch(\Exception $e) {
            echo 'Erro ao listar';
        }
    }

    // listar admin/suporte
    public function pegarAdminSuporte() : array
    {
        try {
        $b = self::conn()->query("SELECT postograd, user FROM user WHERE perfil=1 OR perfil=2");
        return $b->fetchAll(\PDO::FETCH_OBJ);
        }catch(\Exception $e) {
            echo 'Erro ao listar';
        }
    }

     // função para pegar o usuario pelo id
    public function pegarUsuarioCd(int $cd = null) : object
     {
         if ($cd != null) {
             try {
             $pegar = self::conn()->prepare("SELECT secao.id_secao, secao.secao, user.* 
             FROM user 
             LEFT JOIN secao 
             ON secao.id_user = user.id_user 
             WHERE user.id_user=:cd
             ");
             $pegar->bindParam(':cd', $cd);
             $pegar->execute();
             return $pegar->fetchObject();
             }catch(\Exception $e) {
            	echo '<meta HTTP-EQUIV="Refresh" CONTENT="0; URL=?p=home">';
             }
         }
    }

    // editar usuarios
    public function editUsuario(array $dados = null) : bool
    {
        if($dados != null) {
            try {
            self::conn()->beginTransaction();
            $up = self::conn()->prepare("UPDATE user SET 
            user=?,
            postograd=?,
            perfil=?,
            updated_at=?,
            updated_by=?
            WHERE id_user=?");

            $up->execute($dados);
            self::conn()->commit();
            return true;
            }catch(\PDOException $e) {
                echo $e->getMessage();
                //ja verifica usuario duplicado
                echo "<script>alert('Este usuário já está cadastrado em nosso sistema..Tente novamente');</script>";
                self::conn()->rollback();
                return false;
            }
        }
    }

    /**
     * trocar senha
     *
     * @param array $dados
     * @return boolean
     */
    public function trocaSenha(array $dados) : bool
    {
        if($dados != null) {
            self::conn()->beginTransaction();
            try {
            $up = self::conn()->prepare("UPDATE user SET 
            passwd=?
            WHERE id_user=?");
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

      // deletar usuario pelo id
      public function delUsuario(int $cd = null) : bool
      {
         if ($cd != null) {
             try{
             $del = self::conn()->prepare("DELETE FROM user WHERE id_user = :cd");
             $del->bindParam(':cd', $cd);
            //  var_dump($del);
             $del->execute();
             return true;
             } catch(\PDOException $e) {
                //  echo 'Erro ao excluir!!!';
                 return false;
             }
         }
     }
}