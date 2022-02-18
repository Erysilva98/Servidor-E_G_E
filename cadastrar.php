<?php
    require_once 'CLASSES/conectar.php';
	$u = new usuario;
?>

<html lang ="pt-br">
<head>
	<meta charset="utf-8"/>
	<title>Login</title>
	<link rel="stylesheet" type="text/css"href="CSS/estilo.css">

</head>
<body>
<div class="volta">
	<table>
	<td>
		<a href="index.php"><strong>PAGINA INICIAL</a>
	</td>
	</table>
</div>	
<div id="corpo-form-cad">
	<h1>SISTEMA&nbsp; DE &nbsp;CADASTRO</h1>
	<form method="POST" >
		<input type="text" name="nome" placeholder="Nome Completo" maxlength "120" >
		<input type="password" name="acesso" placeholder="Chave de Acesso" maxlength "15">
		<input type="text" name="telefone" placeholder="Telefone" maxlength "20">		
		<input type="email" name="email" placeholder="E-mail" maxlength "30">
		<input type="password" name="senha" placeholder="Senha" maxlength "15">
		<input type="password" name="confsenha" placeholder="Confimar Senha" maxlength "15">
		<input type="submit" placeholder="Enviar">
	</form>
</div>
<?php
	
if (isset ( $_POST['nome'] ))
{
		// addcslashes = impeder uso de script 
		$nome = addslashes ($_POST['nome']);
		$acesso  = addslashes ($_POST['acesso']);
		$telefone = addslashes ($_POST['telefone']);
		$email = addslashes ($_POST['email']);
		$senha = addslashes ($_POST['senha']);
		$confsenha= addslashes ($_POST['confsenha']);
		
		// verficar espaço nulo
		if(!empty($nome) && !empty($acesso) && !empty($telefone)&&!empty($email) && 
			!empty($senha) && !empty($confsenha) )
		{			
				$u->conectar("servidor","localhost","root","");
				$chave = 1998;    // Codigo de Resgistro
				
				if($u->msgErro == "")  // Se estiver vazia, tudo ok!
				{
					if ( $acesso == $chave) 		
					{
						if ($senha == $confsenha) 
						{
							if ($u->cadastrar($nome, $telefone, $email, $senha) )
							{
							?>
								<div class="msg-sucesso">
								Chave Confirmada -
								Cadastrado com Sucesso:
								<a href="index.php">Acesse o Login?&nbsp;<strong>&nbsp;AQUI!</a> 
								</div>
							<?php
							}
							else
							{
							?>
								<div class="msg-erro">
								E-mail ja cadastrado!	
								</div>	
							<?php
							}
						}		
						else
						{
						?>	
							<div class="msg-erro">
								Senha e Confimar Senha: Incorreta!
							</div>	
						<?php
						}
					}
					else
						{
						?>	
							<div class="msg-erro">
								Verifique seu Codigo de Acesso!
							</div>	
						<?php
						}
				}				
				else
				{
					?>
					<div class="msg-erro">
					 <?php  echo"Erro: ".$u->msgErro;?>
					</div> 
					<?php
				}
		}
		else
		{
			?>
			<div  class="msg-erro">
			
				Preencha todos os Campos
			
			</div>	
			<?php
		}
}
?>
</body>
</html>

