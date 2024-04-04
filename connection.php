<?php
session_start();

if(!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit;
}

$email = $_SESSION['email'];

$username = $_SESSION['username']; 
?>

<script type=module src=main1.js></script>

<my-header></my-header>


<html>
<body>
?>

<?php
// Connect to your database

// Create connection
$conn = new mysqli('localhost','root','','rifas_dados');

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Function to create a new table for a raffle
function createRaffleTable($username, $conn) {
    $tableName = "numeros_" . $username;
    $sql = "CREATE TABLE IF NOT EXISTS $tableName (
        id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        numero_rifa INT(6) NOT NULL,
        codigo VARCHAR(5) NOT NULL,
        email VARCHAR(20) NOT NULL,
        data_horario TIMESTAMP DEFAULT CURRENT_TIMESTAMP

    )";


    if ($conn->query($sql) === TRUE) {
        echo "Table $tableName created successfully";
    } else {
        echo "Error creating table: " . $conn->error;
    }
}




function createCompradorTable($username, $conn) {
    $tableName = "dados_compradores_" . $username;
    $sql = "CREATE TABLE IF NOT EXISTS $tableName (
        id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        nome VARCHAR(60) NOT NULL,
        email_comprador VARCHAR(30) NOT NULL,
        telefone BIGINT(15) NOT NULL,
        codigo VARCHAR(5) NOT NULL,
        email VARCHAR(30) NOT NULL,
        date_time TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        
    )";


    if ($conn->query($sql) === TRUE) {
        echo "Table $tableName created successfully";
    } else {
        echo "Error creating table: " . $conn->error;
    }
}



?>


<?php
	
	$img_name2 = $_FILES['imagem_premio']['name'];
	$img_size2 = $_FILES['imagem_premio']['size'];
	$tmp_name2 = $_FILES['imagem_premio']['tmp_name'];
	$error = $_FILES['imagem_premio']['error'];

	$img_name = $_FILES['icone_rifa']['name'];
	$img_size = $_FILES['icone_rifa']['size'];
	$tmp_name = $_FILES['icone_rifa']['tmp_name'];
	$error = $_FILES['icone_rifa']['error'];

	$titulo_da_rifa = $_POST['titulo_da_rifa'];
	$descricao_da_rifa = $_POST['descricao_da_rifa'];
	$numero_de_rifas = $_POST['numero_de_rifas'];
	$chave_pix = $_POST['chave_pix'];
	$aceitar = isset($_POST['aceitar']) ? $_POST['aceitar'] : ''; // Assign an empty string if 'aceitar' is not set in $_POST
	$premio = $_POST['premio'];
	$data_final = $_POST['data_final'];
	$preco = $_POST['preco'];
	
	// Database connection
	$conn = new mysqli('localhost','root','','rifas_dados');
	if($conn->connect_error){
		echo "$conn->connect_error";
		die("Connection Failed : ".$conn->connect_error);
	} else {

	if($img_name2 === "" and $img_name=== ""){
		
					$stmt = $conn->prepare("insert into registration(titulo_da_rifa, descricao_da_rifa, numero_de_rifas, chave_pix, aceitar, premio, data_final, preco, username) values( ?, ?, ?, ?, ?, ?, ?, ?, ?)");
					$stmt->bind_param("ssissssis",$titulo_da_rifa, $descricao_da_rifa, $numero_de_rifas, $chave_pix, $aceitar, $premio, $data_final, $preco, $username);
					$execval = $stmt->execute();

					createRaffleTable($username, $conn);
					createCompradorTable($username, $conn);
		
		echo "Registration successful...";
					$stmt->close();
					$conn->close();
		header("Location: minhas_rifas2.php");
		die();			

	}
	
	elseif ($img_name === "")
				
		

	{
			$img_ex2 = pathinfo($img_name2, PATHINFO_EXTENSION);
			
			
			$img_ex_lc2 = strtolower($img_ex2);	
			$allowed_exs = array("jpg", "jpeg", "png"); 
//continuar apartir daqui
			
				
				$new_img_name2 = uniqid("IMG-", true).'.'.$img_ex_lc2;
				
				$img_upload_path2 = 'premio_imagem/'.$new_img_name2;
				
				move_uploaded_file($tmp_name2, $img_upload_path2);
				// Insert into Database
				
					$stmt = $conn->prepare("insert into registration(titulo_da_rifa, descricao_da_rifa, numero_de_rifas, chave_pix, aceitar, premio, imagem_premio, data_final, preco, username) values( ?, ?, ?, ?, ?, ?, ?, ?, ?, ? )");
					$stmt->bind_param("ssisssssis",$titulo_da_rifa, $descricao_da_rifa, $numero_de_rifas, $chave_pix, $aceitar, $premio, $new_img_name2, $data_final, $preco, $username);
					$execval = $stmt->execute();
		createRaffleTable($username, $conn);
		createCompradorTable($username, $conn);
		echo "Registration successful...";
					$stmt->close();
					$conn->close();
		header("Location: minhas_rifas2.php");
		die();			
}
	elseif($img_name2 === "")
	{//
			


			$img_ex = pathinfo($img_name, PATHINFO_EXTENSION);
			$img_ex_lc = strtolower($img_ex);
			
			$allowed_exs = array("jpg", "jpeg", "png"); 
//continuar apartir daqui
			
				$new_img_name = uniqid("IMG-", true).'.'.$img_ex_lc;
				
				$img_upload_path = 'icone_imagem/'.$new_img_name;
				
				move_uploaded_file($tmp_name, $img_upload_path);
				

		$stmt = $conn->prepare("insert into registration(icone_rifa, titulo_da_rifa, descricao_da_rifa, numero_de_rifas, chave_pix, aceitar, premio, data_final, preco, username) values( ?, ?, ?, ?, ?, ?, ?, ?, ?, ? )");
					$stmt->bind_param("sssissssis", $new_img_name, $titulo_da_rifa, $descricao_da_rifa, $numero_de_rifas, $chave_pix, $aceitar, $premio, $data_final, $preco, $username);
					$execval = $stmt->execute();
		createRaffleTable($username, $conn);
		createCompradorTable($username, $conn);
		echo "Registration successful...";
					$stmt->close();
					$conn->close();		
		header("Location: minhas_rifas2.php");
		die();				
	}
	else{

$img_ex2 = pathinfo($img_name2, PATHINFO_EXTENSION);
			$img_ex = pathinfo($img_name, PATHINFO_EXTENSION);
			$img_ex_lc = strtolower($img_ex);
			$img_ex_lc2 = strtolower($img_ex2);	
			$allowed_exs = array("jpg", "jpeg", "png"); 
//continuar apartir daqui
			
				$new_img_name = uniqid("IMG-", true).'.'.$img_ex_lc;
				$new_img_name2 = uniqid("IMG-", true).'.'.$img_ex_lc2;
				$img_upload_path = 'icone_imagem/'.$new_img_name;
				$img_upload_path2 = 'premio_imagem/'.$new_img_name2;
				move_uploaded_file($tmp_name, $img_upload_path);
				move_uploaded_file($tmp_name2, $img_upload_path2);
				// Insert into Database
				
					$stmt = $conn->prepare("insert into registration(icone_rifa, titulo_da_rifa, descricao_da_rifa, numero_de_rifas, chave_pix, aceitar, premio, imagem_premio, data_final, preco, username) values( ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ? )");
					$stmt->bind_param("sssisssssis", $new_img_name, $titulo_da_rifa, $descricao_da_rifa, $numero_de_rifas, $chave_pix, $aceitar, $premio, $new_img_name2, $data_final, $preco, $username);
					$execval = $stmt->execute();
		createRaffleTable($username, $conn);
		createCompradorTable($username, $conn);
		echo "Registration successful...";
					$stmt->close();
					$conn->close();
		header("Location: minhas_rifas2.php");
		die();
		
	}

}	

?>








<a href="logout"></a>

</body>
</html>