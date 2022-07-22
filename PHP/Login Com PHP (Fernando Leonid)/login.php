<?php

	session_start();

	if (isset($_POST['usuário'], $_POST['senha'])) {
		if ($_POST['usuário'] == 'Ademir' && $_POST['senha'] == '123') { //Aqui deve ir os dados do banco de dados.
			$_SESSION['usuário'] = $_POST['usuário']; //Criando uma sessão de nome "usuário" e associando-na à "usuário".
			header('Location: clientes.php');
		}
	}

	if (isset($_GET['erro'])) { //Verificando se existe o parâmetro "erro" na URL da página.
		$erro = 'É necessário logar para acessar o sistema.'; //Criando a variável "erro".
	}

?>

<!--Criando uma "div" para a exibição do erro (vindo de "acesso.php"):-->

<div style="background-color: coral; margin: 10px 10px 10px 0px; padding: 15px;">
	
	<?php echo $erro ?? ''; //Ternária no PHP. ?>

</div>

<form action="" method="post">
	
	<input type="text" name="usuário" placeholder="Digite o seu nome usuário aqui.">
	<input type="password" name="senha" placeholder="Digte a sua senha aqui.">
	<input type="submit" name="login" value="Login">
	<input type="reset" name="resetar" value="Resetar">

</form>
