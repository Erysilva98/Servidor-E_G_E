<?php
	 require_once 'CLASSES/conectar.php';
	$u = new usuario;
?>

<html lang ="pt-br">  
<head>
	<meta charset="utf-8"/>
	<title>LOGIN</title>
	<link rel="stylesheet" type="text/css"href="CSS/estilo.css">

</head>
<body>
<div id="corpo-form">
	<h1>SERVIDOR&nbsp;&nbsp;&nbsp;&nbsp;E&nbsp;&nbsp;-&nbsp;&nbsp;G&nbsp;&nbsp;-&nbsp;&nbsp;E</h1>
	<form method="POST" >
		<input type="email" placeholder="Usuário" name="email">
		<input type="password" placeholder="Senha" name="senha">
		<input type="submit" placeholder="ACESSAR" a href="pagina.php"> 
		<div class="link">
			<table>
				<td><a href="cadastrar.php"><strong>CADASTRE-SE</a></td>
			</table>
		</div>
	</form>
</div>	
<?php
if (isset ( $_POST['email'] ))
{
		// addcslashes = impeder uso de script 
		$email = addslashes ($_POST['email']);
		$senha = addslashes ($_POST['senha']);
		
		// verficar espaço nulo
		if(!empty($email) && !empty($senha) )
		{	
			$u->conectar("servidor","localhost","root","");
				if( $u->msgErro =="" )
			{
				if ($u->logar($email,$senha) )
				{
					header("location: pagina.php");
				}
				else
				{
				?>
				<div class="msg-erro">
					E-mail ou Senha Incorretos!
				</div>	
				<?php
				}
			}
			else 
			{
			?>
				<div class="msg-erro">
				 <?php echo "Erro: ".$u->msgErro; ?>
				 </div>
			<?php
			}
		}	
		else
		{
		?>
		<div class="msg-erro">	
			Preencha todos os Campos!
		</div>
		<?php	
		}	
}		
?>
</body>
</html>