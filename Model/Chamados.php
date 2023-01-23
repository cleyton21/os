<?php

namespace Model;

include_once "DB.php";

class Chamados extends DB
{
    public function cadChamados(array $dados = null) : bool
    {
            self::conn()->beginTransaction();

            $sql = "INSERT INTO chamados (ticket, id_user, id_incidente, prioridade, descricao, foto, conteudo, tipo, tamanho, alert, solicitante, status, ip, created_at, created_by) 
            VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
            $insert = self::conn()->prepare($sql);
            // var_dump($dados);
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

    // função gerar ticket
    public function gerarTicket($ticket = null)
    {
            $sql = "SELECT ticket FROM chamados 
            WHERE ticket LIKE '$ticket%' 
            ORDER BY ticket 
            DESC LIMIT 1
            ";        
            $a = self::conn()->query($sql);
            // return $count->rowCount();
            return $a->fetchObject();
    }

    // listar chamados
    public function listarChamados(string $status = null, string $estoque = null, int $cd = null, int $equipamento = null, int $incidente = null, int $secao = null) : array
    {
        try {
        // $sql = "SELECT incidentes.incidente, user.user, equipamentos.nome, chamados.* FROM chamados 
        // INNER JOIN incidentes 
        // ON incidentes.id_incidente = chamados.id_incidente 
        // LEFT JOIN equipamentos
        // ON equipamentos.id_equipamento = chamados.id_equipamento
        // INNER JOIN user
        // ON user.id_user = chamados.id_user
        // ";

        $sql = "SELECT secao.id_secao, secao.secao, incidentes.incidente, user.user, equipamentos.nome, chamados.* FROM chamados 
        INNER JOIN incidentes 
        ON incidentes.id_incidente = chamados.id_incidente 
        LEFT JOIN equipamentos
        ON equipamentos.id_equipamento = chamados.id_equipamento
        INNER JOIN user
        ON user.id_user = chamados.id_user
        LEFT JOIN secao
        ON secao.id_user = user.id_user
        ";

        ($status == null && $estoque == null && $equipamento == null && $incidente == null && $secao == null ? $sql.= "ORDER BY ticket DESC" : ""); //concatena, lista todos os chamados

        ($status == "abertos-hoje" ? $sql.= "WHERE date(chamados.created_at) = CURDATE() ORDER BY ticket DESC" : ""); //lista os chamados abertos hoje
        ($status == "pendentes" ? $sql.= "WHERE status != 'Resolvido' ORDER BY ticket DESC" : ""); //lista os chamados pendentes
        ($status == "aguardando-resposta-do-usuario" ? $sql.= "WHERE status = 'Aguardando resposta do usuário' ORDER BY ticket DESC" : ""); //lista os chamados que estão aguardando resposta do usuário
        ($status == "resolvidos-hoje" ? $sql.= "WHERE status = 'Resolvido' AND date(chamados.updated_at) = CURDATE() ORDER BY ticket DESC" : ""); //lista os chamados abertos hoje
        
        ($estoque == "usado" ? $sql.= "WHERE id_estoque = '$cd'" : ""); //lista os chamados que usaram estoque
        
        ($equipamento != "" ? $sql.=" WHERE chamados.id_equipamento='$equipamento' ORDER BY ticket DESC" : "");
        
        ($incidente != "" ? $sql.=" WHERE chamados.id_incidente='$incidente' ORDER BY ticket DESC" : "");
        
        ($secao != "" ? $sql.=" WHERE secao.id_secao='$secao' ORDER BY ticket DESC" : "");
        // var_dump($incidente);
        $b = self::conn()->query($sql);

        return $b->fetchAll(\PDO::FETCH_OBJ);
        }catch(\Exception $e) {
            echo 'Erro ao listar';
        }
    }

     // contar mensagens chamados
    //  public function contarMsgChamados() : array
    //  {
    //      try {
    //      $sql = "SELECT user.user, suporte_chamados.* FROM suporte_chamados
    //      INNER JOIN chamados
    //      ON chamados.id_chamado = suporte_chamados.id_chamado
    //      INNER JOIN user
    //      ON user.id_user = chamados.id_user";

    //     ($_SESSION['scd_perfil'] != 3 ? $sql.= " WHERE alertsm = 1" : "");
        
    //     // condição para caso seja cliente, usar a session
    //     ($_SESSION['scd_perfil'] == 3 ? $sql.= " WHERE '{$_SESSION['scd_user']}' = user AND alertsm = 2" : "");

    //     $sql.= " ORDER BY updated_at DESC
    //     LIMIT 5
    //     ";
 
    //      $b = self::conn()->query($sql);
 
    //      return $b->fetchAll(\PDO::FETCH_OBJ);
    //      }catch(\Exception $e) {
    //          echo 'Erro ao listar';
    //      }
    //  }

    // listar mensagens chamados
    // public function listarMsgChamados() : array
    // {
    //     try {
    //     $sql = "SELECT user.user, suporte_chamados.* FROM suporte_chamados
    //     INNER JOIN chamados
    //     ON chamados.id_chamado = suporte_chamados.id_chamado
    //     INNER JOIN user
    //     ON user.id_user = chamados.id_user";

    //     ($_SESSION['scd_perfil'] != 3 ? $sql.= " WHERE alertsm = 1" : "");

    //     // condição para caso seja cliente, usar a session
    //     ($_SESSION['scd_perfil'] == 3 ? $sql.= " WHERE '{$_SESSION['scd_user']}' = user AND alertsm = 2" : "");

    //     $sql.= " ORDER BY updated_at DESC
    //     LIMIT 5
    //     ";
          
    //     $b = self::conn()->query($sql);

    //     return $b->fetchAll(\PDO::FETCH_OBJ);
    //     }catch(\Exception $e) {
    //         echo 'Erro ao listar';
    //     }
    // }

    // listar mensagens tickets novos
    public function listarMsgChamadosNovos() : array
    {
        try {
        $sql = "SELECT user.user, incidentes.incidente, chamados.* FROM chamados
		INNER JOIN user
        ON user.id_user = chamados.id_user
        INNER JOIN incidentes
        ON incidentes.id_incidente = chamados.id_incidente
        WHERE alert = 1
        ORDER BY created_at DESC
        LIMIT 5
        ";

        $b = self::conn()->query($sql);

        return $b->fetchAll(\PDO::FETCH_OBJ);
        }catch(\Exception $e) {
            echo 'Erro ao listar';
        }
    }

    // listar chamados abertos
    public function listarChamadosAbertos() : array
    {
        try {
        $b = self::conn()->query("SELECT incidentes.incidente, chamados.* 
        FROM chamados 
        INNER JOIN incidentes 
        ON incidentes.id_incidente = chamados.id_incidente 
        WHERE status != 'Resolvido'
        ORDER BY ticket DESC
        ");
        return $b->fetchAll(\PDO::FETCH_OBJ);
        }catch(\Exception $e) {
            echo 'Erro ao listar';
        }
    }

      // listar chamados usuario
      public function listarChamadosUsuario() : array
      {
          try {
          $id_user = $_SESSION['scd_iduser'];
          $b = self::conn()->query("SELECT incidentes.incidente, user.user, equipamentos.nome, chamados.* FROM chamados 
          INNER JOIN incidentes 
          ON incidentes.id_incidente = chamados.id_incidente 
          LEFT JOIN equipamentos
          ON equipamentos.id_equipamento = chamados.id_equipamento
          INNER JOIN user
          ON user.id_user = chamados.id_user
          WHERE user.id_user = '$id_user'
          ORDER BY ticket DESC
          ");
          return $b->fetchAll(\PDO::FETCH_OBJ);
          }catch(\Exception $e) {
              echo 'Erro ao listar';
            //   exit;
          }
      }

     // listar chamados abertos do usuario
     public function listarChamadosAbertosUser() : array
     {
         try {
         $id_user = $_SESSION['scd_iduser'];
         $b = self::conn()->query("SELECT incidentes.incidente, user.user, equipamentos.nome, chamados.* FROM chamados 
         INNER JOIN incidentes 
         ON incidentes.id_incidente = chamados.id_incidente 
         LEFT JOIN equipamentos
         ON equipamentos.id_equipamento = chamados.id_equipamento
         INNER JOIN user
         ON user.id_user = chamados.id_user
         WHERE user.id_user = '$id_user' AND status != 'Resolvido'         
         ORDER BY ticket DESC
         ");

         return $b->fetchAll(\PDO::FETCH_OBJ);
         }catch(\Exception $e) {
             echo 'Erro ao listar';
         }
     }

     // listar chamados/usuarios chartjs
     public function countChamadosUsuarios() 
     {
        $ano = date('Y');
        $mes = date('m');

        $sql = "SELECT user.user 
        FROM chamados 
        INNER JOIN user 
        ON chamados.id_user = user.id_user 
        WHERE Year(chamados.created_at) = '$ano' AND Month(chamados.created_at) = '$mes'
        GROUP BY chamados.id_user, user.user";

        $b = self::conn()->query($sql);            
        $data = $b->fetchAll(\PDO::FETCH_ASSOC);  
        
        foreach($data as $nomes) {
            $teste = $nomes['user'] . ",";
            echo $teste;
        }
     }

     // listar chamados/qtd/usuarios
     public function countQtdChamadosUsuarios() 
     {
        $ano = date('Y');
        $mes = date('m');

        $sql = "SELECT COUNT(user.user) AS qtd
        FROM chamados 
        INNER JOIN user 
        ON chamados.id_user = user.id_user 
        WHERE Year(chamados.created_at) = '$ano' AND Month(chamados.created_at) = '$mes'
        GROUP BY chamados.id_user, user.user";

        $b = self::conn()->query($sql);            
        $data = $b->fetchAll(\PDO::FETCH_ASSOC);  
        
        foreach($data as $nomes) {
            $teste = $nomes['qtd'] . ",";
            echo $teste;
        }
     }

     //conta total incidentes/chamados
    public function incidentesChamados()
    {
        try {
        $ano = date('Y');
        $mes = date('m');

        // $sql = "SELECT COUNT(chamados.id_incidente) AS qtd, chamados.status, chamados.created_at, chamados.updated_at, incidentes.id_incidente, incidentes.incidente 
        // FROM chamados 
        // INNER JOIN incidentes 
        // ON chamados.id_incidente = incidentes.id_incidente 
        // WHERE Year(chamados.created_at) = '$ano' AND Month(chamados.created_at) = '$mes' AND status = 'Resolvido'
        // GROUP BY incidentes.incidente, chamados.status, chamados.created_at, chamados.updated_at
        // ORDER BY qtd DESC";

        $sql = "SELECT COUNT(chamados.id_incidente) AS qtd, chamados.status, SUM(TIMESTAMPDIFF(MINUTE, chamados.created_at, chamados.updated_at)) AS minutos, incidentes.id_incidente, incidentes.incidente, incidentes.cor
        FROM chamados 
        INNER JOIN incidentes 
        ON chamados.id_incidente = incidentes.id_incidente 
        WHERE Year(chamados.created_at) = '$ano' AND Month(chamados.created_at) = '$mes' AND status = 'Resolvido'
        GROUP BY incidentes.incidente, chamados.status
        ORDER BY qtd DESC";

        $b = self::conn()->query($sql);
        return $b->fetchAll(\PDO::FETCH_OBJ);
        }catch(\Exception $e) {
            echo 'Erro ao listar';
        }
    }

      //conta total incidentes/chamados mensal
      public function incidentesChamadosMensal()
      {
          try {
          $ano = date('Y');
          $mes = date('m');
          $b = self::conn()->query("SELECT COUNT(chamados.id_incidente) AS qtd, incidentes.incidente, incidentes.cor
          FROM chamados 
          INNER JOIN incidentes 
          ON chamados.id_incidente = incidentes.id_incidente 
          WHERE Year(chamados.created_at) = '$ano' AND Month(chamados.created_at) = '$mes'
          GROUP BY incidentes.incidente
          ORDER BY qtd DESC
          ");
          return $b->fetchAll(\PDO::FETCH_OBJ);
          }catch(\Exception $e) {
              echo 'Erro ao listar';
          }
      }

    //conta total chamados por máquinas anual por nome
    public function countChamadosNomeMaquinas()
    {
        $sql = "SELECT equipamentos.nome FROM equipamentos
        INNER JOIN chamados
        ON equipamentos.id_equipamento = chamados.id_equipamento
        GROUP BY nome
        ";

        $b = self::conn()->query($sql);            
        $data = $b->fetchAll(\PDO::FETCH_ASSOC);  
        
        foreach($data as $nomes) {
            $teste = $nomes['nome'] . ",";
            echo $teste;
        }

    }

    //conta total chamados por máquinas anual por qtd
    public function countChamadosQtdMaquinas()
    {
        $sql = "SELECT COUNT(equipamentos.nome) AS qtd FROM equipamentos
        INNER JOIN chamados
        ON equipamentos.id_equipamento = chamados.id_equipamento
        GROUP BY nome
        ";

        $b = self::conn()->query($sql);            
        $data = $b->fetchAll(\PDO::FETCH_ASSOC);  

        foreach($data as $nomes) {
            $teste = $nomes['qtd'] . ",";
            echo $teste;
        }            
    }

    //conta total chamados hoje
    // public function countChamadosHoje()
    // {
    //     $sql = "SELECT created_at FROM chamados WHERE date(created_at) = CURDATE()
    //     ";
        
    //     $count = self::conn()->query($sql);

    //     return $count->rowCount();
    // }

     //conta total chamados status aberto
    //  public function countChamadosStatusAberto()
    //  {
    //      $sql = "SELECT status FROM chamados WHERE status != 'Resolvido'
    //      ";
         
    //      $count = self::conn()->query($sql);
 
    //      return $count->rowCount();
    //  }

      //conta total chamados aguardando resposta do usuário
    //   public function countChamadosStatusAguardandoRespostaUsuario()
    //   {
    //       $sql = "SELECT status FROM chamados WHERE status = 'Aguardando resposta do usuário'
    //       ";
          
    //       $count = self::conn()->query($sql);
  
    //       return $count->rowCount();
    //   }

     //conta total chamados resolvidos hoje
    //  public function countChamadosResolvidoHoje()
    //  {
    //      $sql = "SELECT status FROM chamados WHERE status = 'Resolvido' AND DATE(updated_at) = CURDATE();
    //      ";
         
    //      $count = self::conn()->query($sql);
 
    //      return $count->rowCount();
    //  }

     //conta total chamados Janeiro do ano corrente
     public function countChamadosJaneiroAtual()
     {
         $ano = date('Y');
         $mes = date('1');
         $sql = "SELECT created_at FROM chamados WHERE Year(created_at) = '$ano' AND Month(created_at) = '$mes';
         ";
         
         $count = self::conn()->query($sql);
 
         return $count->rowCount();
     }

     //conta total chamados Fevereiro do ano corrente
     public function countChamadosFevereiroAtual()
     {
         $ano = date('Y');
         $mes = date('2');
         $sql = "SELECT created_at FROM chamados WHERE Year(created_at) = '$ano' AND Month(created_at) = '$mes';
         ";
         
         $count = self::conn()->query($sql);
 
         return $count->rowCount();
     }

     //conta total chamados Marco do ano corrente
     public function countChamadosMarcoAtual()
     {
         $ano = date('Y');
         $mes = date('3');
         $sql = "SELECT created_at FROM chamados WHERE Year(created_at) = '$ano' AND Month(created_at) = '$mes';
         ";
         
         $count = self::conn()->query($sql);
 
         return $count->rowCount();
     }

     //conta total chamados Abril do ano corrente
     public function countChamadosAbrilAtual()
     {
         $ano = date('Y');
         $mes = date('4');
         $sql = "SELECT created_at FROM chamados WHERE Year(created_at) = '$ano' AND Month(created_at) = '$mes';
         ";
         
         $count = self::conn()->query($sql);
 
         return $count->rowCount();
     }

     //conta total chamados Maio do ano corrente
     public function countChamadosMaioAtual()
     {
         $ano = date('Y');
         $mes = date('5');
         $sql = "SELECT created_at FROM chamados WHERE Year(created_at) = '$ano' AND Month(created_at) = '$mes';
         ";
         
         $count = self::conn()->query($sql);
 
         return $count->rowCount();
     }

     //conta total chamados Junho do ano corrente
     public function countChamadosJunhoAtual()
     {
         $ano = date('Y');
         $mes = date('6');
         $sql = "SELECT created_at FROM chamados WHERE Year(created_at) = '$ano' AND Month(created_at) = '$mes';
         ";
         
         $count = self::conn()->query($sql);
 
         return $count->rowCount();
     }

     //conta total chamados Julho do ano corrente
     public function countChamadosJulhoAtual()
     {
         $ano = date('Y');
         $mes = date('7');
         $sql = "SELECT created_at FROM chamados WHERE Year(created_at) = '$ano' AND Month(created_at) = '$mes';
         ";
         
         $count = self::conn()->query($sql);
 
         return $count->rowCount();
     }

     //conta total chamados Agosto do ano corrente
     public function countChamadosAgostoAtual()
     {
         $ano = date('Y');
         $mes = date('8');
         $sql = "SELECT created_at FROM chamados WHERE Year(created_at) = '$ano' AND Month(created_at) = '$mes';
         ";
         
         $count = self::conn()->query($sql);
 
         return $count->rowCount();
     }

     //conta total chamados Setembro do ano corrente
     public function countChamadosSetembroAtual()
     {
         $ano = date('Y');
         $mes = date('9');
         $sql = "SELECT created_at FROM chamados WHERE Year(created_at) = '$ano' AND Month(created_at) = '$mes';
         ";
         
         $count = self::conn()->query($sql);
 
         return $count->rowCount();
     }

     //conta total chamados Outubro do ano corrente
     public function countChamadosOutubroAtual()
     {
         $ano = date('Y');
         $mes = date('10');
         $sql = "SELECT created_at FROM chamados WHERE Year(created_at) = '$ano' AND Month(created_at) = '$mes';
         ";
         
         $count = self::conn()->query($sql);
 
         return $count->rowCount();
     }

     //conta total chamados Novembro do ano corrente
     public function countChamadosNovembroAtual()
     {
         $ano = date('Y');
         $mes = date('11');
         $sql = "SELECT created_at FROM chamados WHERE Year(created_at) = '$ano' AND Month(created_at) = '$mes';
         ";
         
         $count = self::conn()->query($sql);
 
         return $count->rowCount();
     }

       //conta total chamados Dezembro do ano corrente
       public function countChamadosDezembroAtual()
       {
           $ano = date('Y');
           $mes = date('12');
           $sql = "SELECT created_at FROM chamados WHERE Year(created_at) = '$ano' AND Month(created_at) = '$mes';
           ";
           
           $count = self::conn()->query($sql);
   
           return $count->rowCount();
       }


     // função para pegar o chamados pelo id
    public function pegarChamadoCd(int $cd = null) 
     {
         if ($cd != null) {
             try {
             self::conn()->beginTransaction(); //abre transação, atualiza tabela chamados

             $pegar = self::conn()->prepare("SELECT incidentes.incidente, incidentes.dica, incidentes.equipamento, equipamentos.nome, materiais.material, estoque.descricao AS descricaoestoque, chamados.* 
             FROM chamados 
             INNER JOIN incidentes 
             ON incidentes.id_incidente = chamados.id_incidente 
             LEFT JOIN equipamentos
             ON chamados.id_equipamento = equipamentos.id_equipamento
             LEFT JOIN estoque
             ON chamados.id_estoque = estoque.id_estoque
             LEFT JOIN materiais
             ON materiais.id_material = estoque.id_material             
             WHERE id_chamado = :cd
             ");
             $pegar->bindParam(':cd', $cd);
             $pegar->execute();

             if($_SESSION['scd_perfil'] != 3) { //para admin/suporte
             $upChamado = self::conn()->prepare("UPDATE chamados SET 
             alert = null
             WHERE id_chamado='$cd'");     
             $upChamado->execute();

             $a = 'lido1';
             $b = 1;
             $dados = array($a, $cd, $b);
             $upSuporteChamado = self::conn()->prepare("UPDATE suporte_chamados SET 
             alertsm = ?
             WHERE id_chamado=? AND alertsm = ?"); 
             $upSuporteChamado->execute($dados);
             }//fim do if

             if($_SESSION['scd_perfil'] == 3){ // para clientes
             $a = 'lido2';
             $b = 2;
             $dados = array($a, $cd, $b);
             $upSuporteChamado = self::conn()->prepare("UPDATE suporte_chamados SET 
             alertsm=?
             WHERE id_chamado=? AND alertsm=?");          
             $upSuporteChamado->execute($dados);
             } //fim do if
 
             self::conn()->commit();
             return $pegar->fetchObject();
             
             }catch(\Exception $e) {
                self::conn()->rollback();
                return false;
                // echo $e->getMessage();
                // echo $e->getLine();
            	// echo '<meta HTTP-EQUIV="Refresh" CONTENT="0; URL=?p=home">';
             }
         }
    }

    //pegar as msgns dos chamados
    public function pegarMsgCd(int $cd = null)
    {
        try {
        $b = self::conn()->prepare("SELECT suporte_chamados.id, chamados.id_chamado, suporte_chamados.mensagem, suporte_chamados.foto, suporte_chamados.conteudo, suporte_chamados.tipo, suporte_chamados.tamanho, suporte_chamados.privacidade,suporte_chamados.updated_at, suporte_chamados.updated_by
        FROM suporte_chamados 
        INNER JOIN chamados 
        ON chamados.id_chamado = suporte_chamados.id_chamado 
        WHERE chamados.id_chamado = :cd
        ");

        $b->bindParam(':cd', $cd);
        $b->execute();

        return $b->fetchAll(\PDO::FETCH_OBJ);
        }catch(\Exception $e) {
            echo 'Erro ao listarpp';
        }
    }

     // editar chamados cliente
     public function editChamadoUsuario(array $dadosChamadoCliente, $dadosSuporte) : bool
     {
         if($dadosChamadoCliente != null) {
             self::conn()->beginTransaction(); //abre transação, atualiza tabela chamados
             try {
             $upChamado = self::conn()->prepare("UPDATE chamados SET 
             updated_at=?,
             updated_by=?
             WHERE id_chamado=?");
          
             $upChamado->execute($dadosChamadoCliente);
 
             $sql = "INSERT INTO suporte_chamados (id_chamado, alertsm, mensagem, privacidade, updated_at, updated_by) 
             VALUES (?,?,?,?,?,?)"; //insere uma linha na tabela suporte aos chamados
             $insert = self::conn()->prepare($sql);           
             $insert->execute($dadosSuporte);
 
             self::conn()->commit();
             return true;
             }catch(\PDOException $e) {
                //  echo $e->getMessage();
                 self::conn()->rollback();
                 return false;
             }
         }
     }

    // editar chamados
    public function editChamado(array $dadosChamado, $dadosSuporte) : bool
    {
        if($dadosChamado != null) {
            self::conn()->beginTransaction(); //abre transação, atualiza tabela chamados
            try {
            $upChamado = self::conn()->prepare("UPDATE chamados SET 
            status=?,
            tecnico=?,
            id_equipamento=?,
            id_estoque=?,
            updated_at=?,
            updated_by=?
            WHERE id_chamado=?");           
            $upChamado->execute($dadosChamado);

            // var_dump( $upChamado->execute($dadosChamado));
            // var_dump($dadosSuporte); 

           
            //atualiza estoque
            if($dadosChamado[3] != "") { //so executa essa query, se o estoque estiver preenchido
            $upEstoque = self::conn()->prepare("UPDATE estoque SET 
            usado=1
            WHERE id_estoque='$dadosChamado[3]'");            
            $upEstoque->execute(); 
            }

            $sql = "INSERT INTO suporte_chamados (id_chamado, alertsm, mensagem, foto, conteudo, tipo, tamanho, privacidade, updated_at, updated_by) 
            VALUES (?,?,?,?,?,?,?,?,?,?)"; //insere uma linha na tabela suporte aos chamados
            $insert = self::conn()->prepare($sql);           
            // var_dump($insert); 
            $insert->execute($dadosSuporte);
            // var_dump($insert->execute($dadosSuporte));  exit;
            // var_dump($dadosSuporte); exit;

            self::conn()->commit();
            return true;
            }catch(\PDOException $e) {
                // echo $e->getMessage();
                self::conn()->rollback();
                return false;
            }
        }
    }

}