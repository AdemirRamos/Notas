<?php
	
	//Iniciando uma sessão para exibir uma variável global ("$_SESSION['mensagem']"):

	session_start(); 

	include_once 'connection.php';

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Listar - Celke</title>

	<style type="text/css">
		
		a {
			display: block;
		}

	</style>

</head>

<body>
	
	<a href="index.php">Listar</a>
	<a href="cadastro.php">Cadastrar</a>

	<h1>Listar</h1>

	<?php

		//Exibindo a variável global:

		if (isset($_SESSION['mensagem'])) {
			echo $_SESSION['mensagem'];
			unset($_SESSION['mensagem']);
		}

		//Implementando a paginação:

		$página_atual = filter_input(INPUT_GET, "page", FILTER_SANITIZE_NUMBER_INT);

		//var_dump($página_atual);

		$página =  (!empty($página_atual)) ? $página_atual : 1;

		//Definindo a quantidade de registros por página:

		$limite_resultados = 2;

		//Calculando o ínicio da vizualização:

		$ínicio = ($limite_resultados * $página) - $limite_resultados;

		$query_usuários = "SELECT id, nome, email FROM usuários ORDER BY id DESC LIMIT $ínicio, $limite_resultados"; /*Pesquisar.*/

		//"Strings" com aspas duplas permitem interpolação.

		$resultado_usuários = $connection->prepare($query_usuários);
		$resultado_usuários->execute();

		//Verificando se a "query" existe e se obteve algum resultado:

		if (($resultado_usuários) AND ($resultado_usuários->rowCount() != 0)) {
			//Percorrendo os registros:

			while($linha_usuários = $resultado_usuários->fetch(PDO::FETCH_ASSOC /*Pesquisar.*/)) {
				//var_dump($linha_usuários); -> Apenas para testar se tudo está ok.

				//Imprimindo o resultado na tela (de maneira mais organizada):

				extract($linha_usuários); /*Pesquisar.*/

				echo "ID: $id <br>";
				echo "Nome: $nome <br>";
				echo "E-mail: $email <br>";
				echo "<hr>";

				//Outra opção de escrita: echo "ID: ". $linha_usuários['id'] ."<br>";
			}
		}

		//Contando a quantidade de registros no banco de dados:

		$queryQuantidadeRegistros = "SELECT COUNT(id) AS quantidade_registros FROM usuários";

		$resultadoQuantidadeRegistros = $connection->prepare($queryQuantidadeRegistros);

		$resultadoQuantidadeRegistros->execute();

		//Lendo o resultado:

		$linhaQuantidadeRegistros = $resultadoQuantidadeRegistros->fetch(PDO::FETCH_ASSOC);

		//Contando a quantidade de páginas no projeto:

		$quantidade_páginas = ceil($linhaQuantidadeRegistros['quantidade_registros'] / $limite_resultados);

		//Função para arredondar para cima.

		//"link" para a primeira página:

		echo "<a href='index.php?page=1'>Primeira Página</a>";

		//Avançando duas páginas a partir da atual:

		$máximo_páginas = 2;

		for($página_anterior = $página - $máximo_páginas; $página_anterior <= $página - 1; $página_anterior++) {
			//Excluindo páginas anteriores à primeira:

			if ($página_anterior >= 1) {
				//Imprimindo a página:

				echo "<a href='index.php?page=$página_anterior'>Página Anterior</a>";
			}
		}

		//Indicando as páginas:

		echo "<a href='!'>$página</a>";

		//Exclamação também anula o redirecionamento do "link".

		for ($próxima_página = $página + 1; $próxima_página <= $página + $máximo_páginas; $próxima_página++) {
			//Impedindo que páginas vazias sejam mostradas:

			if ($próxima_página <= $quantidade_páginas) {
				//Imprimindo as duas páginas posteriores à atual:

				echo "<a href='index.php?page=$próxima_página'>$próxima_página</a>";
			}
		}

		//Última página:

		echo "<a href='index.php?page=$quantidade_páginas'>Última Página</a>";

		else {
			echo "<p syte='margin-bottom: 15px; color: red;'>Usuário não encontrado.</p>";
		}

	?>

</body>

</html>
