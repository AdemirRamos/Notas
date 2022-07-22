<?php

	session_start();

	//Se a "sessão usuário" não existir, redirecione o usuário para o menu de login:

	if (!isset($_SESSION['usuário'])) {
		header('Location: login.php?erro=true'); //Criando uma mensagem de erro através de um parâmetro.
		exit; //Garantido que o usuário será mandado para outra página ("login.php").
	}

	//As variáveis de sessão ficam disponíveis enquanto o navegador não for fechado.
	
?>
