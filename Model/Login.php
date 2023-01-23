<?php 
namespace Model;

include_once "DB.php";

class Login extends DB
{
	private $tabela;

//==============================================================================    
//      função de construção
//==============================================================================    
	public function __construct($tab = 'user') 
	{
		$this->tabela = $tab;
	}

//==============================================================================    
    //função de validacao de informações
//==============================================================================    
	public function validar($user, $passwd)
	{
		if ($this->isLogado()) {
			return false;
		}

		$verificar = self::conn()->prepare("SELECT * FROM ".$this->tabela." WHERE user = ?");
		// var_dump($verificar); exit;
		$dados = array($user);
		// var_dump($dados); 
		$verificar->execute($dados);
		// var_dump($verificar->execute($dados));exit;
		$validar = $verificar->fetchObject();
		// var_dump($validar); exit;
		return (password_verify($passwd, $validar->passwd) ? true : false);
	}

//==============================================================================    
//          função de logar
//==============================================================================     
	public function logar($user, $passwd, $lem_senha)
	{
        //chamar metodo de validacao
		if ($this->validar($user, $passwd)){

			$exec = self::conn()->prepare("SELECT * FROM ".$this->tabela." WHERE user = '$user'");
			$exec->execute();

			$User = $exec->fetchObject();
			// //scd = security cod - so pra diferenciar
			$_SESSION['user_logged_in'] = 'yes';
			$_SESSION['scd_iduser'] = $User->id_user;
			$_SESSION['scd_user'] = $User->user;
			$_SESSION['scd_perfil'] = $User->perfil;
			$_SESSION['scd_ip'] = $_SERVER["REMOTE_ADDR"];

			$_SESSION['scd_passwd'] = $passwd;
			$_SESSION['scd_lem_senha'] = $lem_senha;
			// var_dump($User->user);

			//registra dt_acesso do usuário e ip da máquina
			$ip = $_SERVER["REMOTE_ADDR"];
			$dt_log = date('Y/m/d H:i:s', time()); //data atual
			$Rlog = self::conn()->prepare("UPDATE ".$this->tabela." SET login_in = '$dt_log', ip = '$ip' WHERE user = '$user'");
			$Rlog->bindParam(':user', $user);
			$Rlog->execute();
			//=====================================

			return true;
		}else{
			return false;
		}
	}

//==============================================================================    
//   função para decrementar a quantidade de usuarios on quando fizer logout
//==============================================================================     
// private function decUserOn($email){
// 	$logado = self::conn()->prepare("UPDATE ".$this->tabela." SET is_logado = 0 WHERE email = '$email'");
// 	$logado->execute();
// 	return true;
// }

//==============================================================================    
//          função para verificar se o usuário esta logado
//==============================================================================    
	public function isLogado()
	{
		if (isset($_SESSION['user_logged_in']) && ($_SESSION['user_logged_in']) != ''){
			return true;
		}else{
			return false;
		}
	}

//==============================================================================    
//          função para logout
//==============================================================================    
	public function Sair($user)
	{
		if($this->isLogado()){
			// $this->decUserOn($user);
			//elimina as sessions manualmente por segurança	
			unset($_SESSION['user_logged_in']);
			// unset($_SESSION['scd_email']);
			// unset($_SESSION);

        //destuição automatica de todas as sessions (redundância)
			// session_destroy();
			echo '<meta HTTP-EQUIV="Refresh" CONTENT="0; URL=index.php">';
			return true;
		}else{
			return false;
		}
	}

}
?>
