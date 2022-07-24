<?php

	include_once 'connection.php';

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Cadastro - Celke</title>

	<style type="text/css">
		
		.marginBottom {
			margin-bottom: 15px;
		}

		.marginRight {
			margin-right: 10px;
		}

		label {
			font-weight: bolder;
		}

	</style>

</head>

<body>
	
	<h1>Cadastro</h1>

	<!--Também é possível dar nome aos formulários. Esse nome pode ser usado para a validação do formulário via JS.-->

	<?php

		//Recebendo os dados do formulário (com filtragem):

		$dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);

		//Parâmetros: 1ª: tipo de método do "input"; 2ª: garante que os dados serão recebidos como uma "string".

		//Verificando se o usuário clicou no botão de enviar:

		if (!empty($dados['botão-cadastro'])) {
			//var_dump($dados); -> Imprimindo o resultado vindo dos "input's".

			$empty_input = false;

			//Através do HTML5, é possível impedir que dados sejam enviados com determinados cmapos em branco;
			//Porém, essa validação só funcionará em navegadores com suporte ao HTML5;
			//Onde não for esse o caso, o usuário poderá enviar formulários com campos obirgatórios em branco;
			//Para garantir que isso não ocorrerá indpendentemente da versão do HTML do navegador do usuário, usamos o PHP;

			//Prrenchimento obrigatório de campos com PHP:

			$dados = array_map('trim', $dados); //"trim" remove espaços em branco no começo e final dos campos.

			//Verificando se há algum campo vazio no vetor "$dados":

			if (in_array("", $dados)) {
				$empty_input = true;
				echo "<p style='margin-bottom: 15px; color: red;'>Erro! É necessário preencher todos os campos.</p>";
			}

			//Verificando se o formato do e-mail passado é válido:
			//P. S.: Essa não se trata de uma verificação quanto a existência ou não existência do e-mail.

			else if (!filter_var($dados['email'], FILTER_VALIDATE_EMAIL)) {
				$empty_input = true;
				echo "<p style='margin-bottom: 15px; color: red;'>E-mail inválido.</p>";
			}

			//O cadastro somente será efetuado caso a variável "$empty_input" tenha como valor "false":

			if (!$empty_input) {
				//Inserindo os dados no banco de dados:

				//Recomenda-se não usar os parâmetros direto na "query"; recomenda-se substituí-los por "links":

				//$query_usuário = "INSERT INTO usuários (nome, email) VALUES ('". $dados['nome'] ."', '". $dados['email'] ."')";

				//P. S.: Talvez seja possível adicionar os dados dos "input's" sem concatená-los à "string" (via interpolação).

				$query_usuário = "INSERT INTO usuários (nome, email) VALUES (:nome, :email)";

				//Os nomes dos "links" são facultativos.

				//A ordem das colunas no banco de dados deve ser a mesma ordem aqui escrita (caso contrário, haverá erros);
				//Por conseguinte, o mesmo vale para os valores.

				//Preparando a "query_usuário" para inserir os dados no banco de dados:

				$cadastrar_usuário = $connection_port->prepare($query_usuário); //Atribuindo a preparação a uma variável para executá-la:

				//Indicando os valores dos "links":

				$cadastrar_usuário->binParam(':nome', $dados['nome'], /*Indicação do tipo primitivo:*/ PDO::PARAM_STR);
				$cadastrar_usuário->binParam(':email', $dados['email'], PDO::PARAM_STR);

				$cadastrar_usuário->execute();

				//Retornando uma mensagem (para o usuário no caso de sucesso ou insucesso ao se cadastrar):

				if ($cadastrar_usuário->rowCount()) {
					echo "<p style='margin-bottom: 15px; color: green;'>Cadastro efetuado com sucesso.</p>";

					//Apagando todos os campos caso o usuário tenha feito o cadastro com sucesso:

					unset($dados);
				}

				else {
					echo "<p style='margin-bottom: 15px; color: red;'>Erro ao cadastrar.</p>";
				}
			}
		}

	?>

	<form action=" <?php echo $_SERVER['PHP_SELF']; ?>" method="post" name="cadastro_usuário">
		
		<div class="marginBottom">

			<label for="nome_id" class="marginRight">Nome:</label>

			<input
				type="text"
				name="nome"
				id="nome_id"
				placeholder="Nome completo"
				
				value="<?php /*Mantendo os dados no formulário após o usuário clicar em "Enviar" (caso haja algum erro):*/

					if (isset($dados['nome'])) {
						echo $dados['nome'];
					}

				?>"

				>

		</div>

		<div class="marginBottom">
			
			<label for="email_id" class="marginRight">E-mail:</label>

			<input
				type="email"
				name="email"
				id="email_id"
				placeholder="E-mail: abc123@gmail.com"

				value="<?php /*Repetindo o mesmo processo para o e-mail:*/

					if (isset($dados['email'])) {
						echo $dados['email'];
					}

				?>"

				>

		</div>

		<div>
			
			<input type="submit" name="botão-cadastro" value="Cadastrar">

		</div>

	</form>

</body>

</html>
