<?php
	session_start();
	if(!isset($_SESSION['cod']))
	{
		header ("location: index.php");
		exit;
	}
	require_once 'class-home.php';
	$p = new Pagina("servidor","localhost","root","");
?>
<!DOCTYPE html>

<html lang="pt-br">
<head>
	<meta charset="uft-8">
	<title>SERVIDOR EGE</title>
	<link rel="stylesheet" href="CSS/layout.css">
</head>
<body>
	<?php
	if(isset($_POST['nome'] ) )  
	//Verificar se Clicou em CADASTRAR ou EDITAR
	{
		//----------------------EDITAR----------------------
		if(isset($_GET['cod_up']) && !empty($_GET['cod_up']))
		{
			$cod_upd = addslashes($_GET['cod_up']);
			$nome = addslashes($_POST['nome']);
			$telefone = addslashes($_POST['telefone']);
			$email = addslashes($_POST['email']);
			$senha = addslashes($_POST['senha']);
			
			if(!empty($nome) &&  !empty($telefone) && !empty($email) && !empty($senha) )
			{
				//Atualização do Servidor
				$p->atualizarUser($cod_upd, $nome,$telefone,$email,$senha);
				header("location: pagina.php");
			}
			else
			{
			?>	
				<div class="aviso">
					<img src="Imagen/aviso1.jpg">
					<h4>PREENCHA TODOS OS CAMPOS</h4>
				</div>
			<?php
			}
				
		}
		//--------------------CADASTRAR-----------------------
		else
		{
			$nome = addslashes($_POST['nome']);
			$telefone = addslashes($_POST['telefone']);
			$email = addslashes($_POST['email']);
			$senha = addslashes($_POST['senha']);
			
			if(!empty($nome) &&  !empty($telefone) && !empty($email) && !empty($senha) )
			{
				//Cadastro no Servidor
				if ( !$p->cadastroPagina($nome,$telefone,$email,$senha) )
				{
				?>	
				<div class="aviso">
					<img src="IMAGEN/aviso1.jpg">
					<h4>E-MAIL JA CADASTRADO </h4>
				</div>
				<?php							
				}	
			}
			else
			{
			?>	
				<div class="aviso">
					<img src="IMAGEN/aviso1.jpg">
					<h4>Preencha Todos os Campos</h4>
				</div>
			<?php
			}			
		} // Fim do codigo CADASTRAR	

	} // Fim da Verificação Linha { 26
	
		if(isset($_GET['cod_up']) ) // Verificar se o Usuário Clicou em EDITAR
		{
			$cod_update = addslashes($_GET['cod_up']);
			$res = $p->buscarUser($cod_update);		
		}
	?>
	<section id="esquerda">
		<form method="POST">
			<h2>CADASTRAR MEMBROS</h2>
			<label for="nome">&nbsp;&nbsp;NOME</label>
			<input type="text" name="nome" id="nome"
				value="<?php if(isset($res)){ echo $res['nome']; }?>"
			>
			<label for="telefone">&nbsp;&nbsp;TELEFONE</label>
			<input type="text" name="telefone" id="telefone"
				value="<?php if(isset($res)){ echo $res['telefone']; }?>"
			>
			<label for="email">&nbsp;&nbsp;E-MAIL</label>
			<input type="email" name="email" id="email"
				value="<?php if(isset($res)){ echo $res['email']; }?>"
			>
			<label for="senha">&nbsp;&nbsp;SENHA</label>
			<input type="text" name="senha" id="senha"
				value="<?php if(isset($res)){ echo $res['senha']; }?>"
			>
			<input type="submit" value="<?php if(isset($res)){echo"ATUALIZAR";}
											else{echo"CADASTRAR";}?>">
			<div id="pag">
				<table>
				<td>
					<a href="index.php"><strong>PAGINA INICIAL</a>
				</td>
				</table>
			</div>								
			
		</form>
	</section>
	<section id="direita">
		<table>
			<tr id="titulo">
				<td>NOME</td>  
				<td>TELEFONE</td>
				<td>E-MAIL</td>
				<td>SENHA</td>
				<td>OPÇÕES</td>		
			</tr>
		<?php
		// Cod de Exibição de Dados
			$dados = $p->buscarDados();
			if(count($dados) > 0)   // Tem Registro no Servidor
			{
				for ($i=0; $i < count($dados); $i++)
				{
					echo "<tr>";  // Linha
                    foreach ($dados[$i] as $k => $v)
					{
						if($k != "cod")
						{
							echo "<td>".$v."</td>";    // v =valor exibar na coluna  
						}
					}
					?>
		<td>
			<a href="pagina.php?cod_up=<?php echo $dados[$i]['cod'];?>">EDITAR</a>
			<a href="pagina.php?cod=<?php echo $dados[$i]['cod'];?>">DELETAR</a>
		</td>
				<?php
					// Fim da Linha da Tabela de Registro
					echo "</tr>";
					
				}// Fim do FOR
			
			} //Fim da contagem de Dados
			else  // Sem Registro no Servidor
			{
			?>		
		</table>
			<div class="aviso">
				<h4>SEM CADASTRO NO SISTEMA !</h4>
			</div>
			<?php
			}
		?>
	
	</section>
</body>
</html>

<?php
	if(isset($_GET['cod']))
	{
	$cod_ed = addslashes($_GET['cod']);
	$p->deletarDados($cod_ed);
	header("location: pagina.php");
	}
?>