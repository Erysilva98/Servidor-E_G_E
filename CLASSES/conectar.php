<?php
class usuario
{	
	private $pdo;
	public $msgErro =""; // Tudo Ok!
	
	public function conectar ($nome, $host, $usuario, $senha)
		{
			global $pdo;
			try
			{
				$pdo = new PDO ("mysql:dbname=".$nome.";host=".$host,
								$usuario,$senha);
			}
			catch (PDOException $e)
			{
				$msgErro = $e-> getMessage();	
			}
	} 
	
	public function cadastrar($nome, $telefone, $email, $senha)
	{
		global $pdo;
		//verificar email
		$sql = $pdo->prepare("SELECT cod FROM dados WHERE email = :e");
		$sql->bindValue(":e", $email);
		$sql->execute();
		
		if ($sql->rowCount() > 0)
		{
			return false; // ja cadastrado
		}
		else
		{
			//caso não, cadastrar
			$sql = $pdo->prepare("INSERT INTO dados (nome, telefone, email, senha)
								 VALUES (:n, :t, :em, :sn)");
			$sql->bindValue(":n", $nome);
			$sql->bindValue(":t", $telefone);
			$sql->bindValue(":em", $email);
			$sql->bindValue(":sn", md5($senha)); // md5  Cpitrografia, embaralhar senha, do Admistrador
			$sql->execute();
			return true;
		}
	}

	public function logar ($email, $senha)
	{
		global $pdo;
		// verificar se existe cadastros, se sim
		$sql = $pdo->prepare("SELECT cod FROM dados WHERE
								email=:em AND senha = :sn");
		$sql->bindValue(":em",$email);
		$sql->bindValue(":sn",md5($senha)); //*Atenção: Com o md5($senha) apenas quem tem senha com 
		$sql->execute();			  // Cpitrografia faz Login, mesmo estando no banco de dados
		if ($sql->rowCount() > 0)
		{
			// entrar no banco (sessao)
			$dado = $sql->fetch();   // fetch retornar os valores em array    
			session_start();
			$_SESSION['cod'] = $dado['cod'];
			return true; // Login efetuado
		}
		
		else
			//caso não, Cadastrado
		{
			return false; // Erro de Login
		}	
	}
}	
?>