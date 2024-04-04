
<html>
<head>
<title>login</title>
</head>
<body>

		
			<?php
		$conn = mysqli_connect  ("localhost","root","","rifas_dados");
		if($conn-> connect_error){
			die("connection fail:". $conn-> connect_error);
		}
		
		$sql = "SELECT email,password, username from signup where username=username2 email=email2, password=password2;";
		$result = $conn-> query($sql);
		if ($result-> num_rows > 0){
			while($row = $result-> fetch_assoc()){
			echo $row["password"] ."<br>".$row["email"];
		}
		echo "</table>";
	}
	else{
		echo "0";}
	$conn-> close();


		?>
	


	
</body>
</html>		