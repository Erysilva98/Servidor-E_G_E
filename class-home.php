<?php
Class Pagina   // = $p
{
	private $pdo;
	
	// Conxeão com o Banco o Servidor
	public function __construct($dbname, $host, $user, $senha)
	{
		try
		{
			$this->pdo = new PDO("mysql:dbname=".$dbname.";host=".$host,$user,$senha);
		}
		catch (PDOException $e){
			echo "Erro de Conexão com o Servidor: ".$e->getMessage();
			exit();
		}
		catch (Exception $e){
			echo "Erro Encontrado: ".$e->getMessage();
			exit();	
		}
	} //Fim da Função Construtora
	
	public function buscarDados()
	{
		$res = array();
		$cmd = $this->pdo->query("SELECT * FROM dados ORDER BY nome");
		$res = $cmd->fetchAll(PDO::FETCH_ASSOC);;
		return $res;
	} // Fim
	
	// Cadastrado de Pessoas no Servidor pela Pagina WEB
	public function cadastroPagina($nome, $telefone, $email, $senha)
	{
		// Verificação de Email no Servidor
		$cmd = $this->pdo->prepare("SELECT cod FROM dados WHERE email = :e");
		$cmd->bindValue(":e",$email);
		$cmd->execute();
		if($cmd->rowCount() > 0)  //E-mail ja Cadastrado
		{
			return false;
		}
		else  // Nenhum registro
		{
			$cmd = $this->pdo->prepare("INSERT INTO dados (nome, telefone, email, senha)
								 VALUES (:n, :t, :em, :sn)");
			$cmd->bindValue(":n",$nome);
			$cmd->bindValue(":t",$telefone);
			$cmd->bindValue("em",$email);
			$cmd->bindValue("sn",md5($senha)); //*Sem o md5($senha) ao cadastrar o usuario 
			$cmd->execute();				// na Pagina do servidor a senha não terá Cpitrografia, 
			return true;						// sem acesso ao Login
		}	
	} // Fim da Funcão CadastradoPagina
	
	public function deletarDados($cod)
	{
		$cmd = $this->pdo->prepare("DELETE FROM dados WHERE cod = :cod");
		$cmd->bindValue(":cod",$cod);
		$cmd->execute();
	} // Fim
	
	
	// Buscar Um registro no Servidor
	public function buscarUser($cod)
	{
		$res = array();
		$cmd = $this->pdo->prepare("SELECT * FROM dados WHERE cod = :cod");
		$cmd->bindValue(":cod",$cod);
		$cmd->execute();
		$res = $cmd->fetch(PDO::FETCH_ASSOC);
		return $res;
	}
	
	// Realizar a Atualização no Servidor
	public function atualizarUser($cod, $nome, $telefone, $email, $senha)
	{
		$cmd = $this->pdo->prepare("UPDATE dados SET nome = :n, telefone = :t, 
									email = :e, senha = :sn WHERE cod = :cod");
		$cmd->bindValue(":n",$nome);	
		$cmd->bindValue(":t",$telefone);
		$cmd->bindValue(":e",$email);
		$cmd->bindValue(":sn",md5($senha)); //*Sem o md5($senha) ao editar o usario na Pagina do servidor
		$cmd->bindValue(":cod",$cod);		// a senha não terá Cpitrografia, e sem acesso ao Login
		$cmd->execute();		
	}
}

?>