<?php
session_start();

if(!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit;
}

$email = $_SESSION['email'];
$username = $_SESSION['username']; 
?>
<!DOCTYPE html>
<html>
<script type=module src=main1.js></script>

<my-header></my-header>
	<head>
		<meta charset="UTF-8">
		<title>Crie sua rifa</title>
	</head>
	<body>

		
		<br>
		<center>
<h1>Crie sua rifa</h1>
<style>
                    h1{

                        font-size: 50px;
                    }
                   
                    </style>
<br>

		<form action="connection.php" method="post" enctype="multipart/form-data">
			<p>Icone</p>
			<br>
			<label for="file">Escolha uma imagem</label>
	  		<input type="file" accept="image/jpeg, image/png, image/jpg" name="icone_rifa" id="icone_rifa" :optional>
	  		<br>
	  		<br>
	  		<p>Título</p>

	  		<input type="text" name="titulo_da_rifa" maxlength="200" id="titulo_da_rifa" required>
	  		<br>
	  		<br>
	  		<p>Descrição</p>

	  		<textarea name="descricao_da_rifa" rows="10" cols="100" maxlength="1500" id="descricao_da_rifa" required></textarea>
	  		
	  		<br>
	  		<br>
	  		
			<p>Número de rifas</p>
			<input type="number" name="numero_de_rifas" maxlength="5" id="numero_de_rifas" required>
			<br>
	  		<br>

			<p>Chave pix</p>
			<input type="text" name="chave_pix" maxlength="32" id="chave_pix" required>
			<br>
	  		<br>

			<p>Deseja receber informações sobre a compra das rifas no email?</p>
			<input type="checkbox" name="aceitar" value="y" id="aceitar">
			<br>
	  		<br>

			<p>Prêmio</p>
			<input type="text" name="premio" maxlength="100" id="premio" required>
			<input type="file" accept="image/jpeg, image/png, image/jpg" name="imagem_premio" id="imagem_premio" :optional>
			<br>
	  		<br>
			<p>Data de finalização</p>
			<input type="date" name="data_final" id="data_final" required>
			<br>
	  		<br>
			<p>Preço</p>
			<input type="number" name="preco" id="preco" required>
			<br>
			<br>
		<input type="submit" value="Continuar"/>
			<br>
			<br>
		</form>	
        
        <button> <a href="logout.php">Logout</a></button>
			

			</center>
			<br>
	</body> 
</html>	