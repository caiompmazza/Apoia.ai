
<?php
	
	

	$username = $_POST['username'];
	$email = $_POST['email'];
	$password = $_POST['password'];
	
	// Database connection
	$conn = new mysqli('localhost','root','','rifas_dados');
	if($conn->connect_error){
		echo "$conn->connect_error";
		die("Connection Failed : ".$conn->connect_error);
	} else {


	$stmt = $conn->prepare("insert into signup(username, email, password) values( ?, ?, ? )");
					$stmt->bind_param("sss", $username, $email, $password);
					$execval = $stmt->execute();
		
	header("location: login.php");
					$stmt->close();
					$conn->close();

}
?>