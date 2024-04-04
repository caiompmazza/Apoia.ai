
<html>
<head>
<title>teste</title>
</head>
<body>

		
		<?php
		$conn = mysqli_connect  ("localhost","root","","rifas_dados");
		if($conn-> connect_error){
			die("connection fail:". $conn-> connect_error);
		}

		$sql = "SELECT icone_rifa, titulo_da_rifa, descricao_da_rifa, numero_de_rifas, chave_pix from registration where id='5';";
		$result = $conn-> query($sql);
		if ($result-> num_rows > 0){
			while($row = $result-> fetch_assoc()){
			echo $row["titulo_da_rifa"] ."<br>".$row["descricao_da_rifa"];


		}
		echo "</table>";
	}
	else{
		echo "0";}
	$conn-> close();


		?>
	
</body>
</html>		