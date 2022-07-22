<?php session_start() ?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>PHP Login</title>

</head>

<body>
	
	<?php

		//Ao se trabalhar com sessões PHP, a sua primeira linha de código (sempre) deve ser: "<php session_start()>".
		//P. S.: Com interrogações.

		if (!isset($_SESSION['login'])) {//Caso não exista a o arquivo php com o nome "login".
			include('login.php'); //Inclua o arquivo "login.php"

			if (isset($_POST['action'])) {
				//echo "Formulário enviado com sucesso! <hr>"; Aqui será feito o "login" (sem banco de dados).

				$login = 'Ademir';
				$senha= 123;

				$nome_form = $_POST['nome'];
				$senha_form = $_POST['senha'];

				//Efetuando o "login":

				if ($login == $nome_form && $senha == $senha_form) {
					$_SESSION['login'] = true;

					//Se pode trocar o "true" por algum outro valor. Exemplo: "$_SESSION['login'] = $login".

					//Redirecionando o usuário para o destino:

					header('Location: home.php');
				}

				else {
					echo 'Dados inválidos!';
				}
			}
		}

		else {
			//Criando o "logout":

			if (isset($_GET['logout'])) {
				unset($_SESSION['login']);
				session_destroy();
				header('Location: index.php');
			}

			include('home.php');
		}
	?>

</body>

</html>
