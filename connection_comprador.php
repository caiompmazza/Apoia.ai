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
<head>
    <title>connection_comprador</title>
</head>
<body>
<script type=module src=main1.js></script>

<my-header></my-header>
<br>
<center>

<?php



if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = $_POST['nome'];
    $email_comprador = $_POST['email'];
    $telefone = $_POST['telefone'];

    // Generate a random code for the user
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $codigo = '';
    for ($i = 0; $i < 5; $i++) {
        $codigo .= $characters[random_int(0, $charactersLength - 1)];
    }

    // Establish a connection to the database
    $conn = new mysqli('localhost', 'root', '', 'rifas_dados');
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    } else {
        // Insert user data into the 'dados_compradores' table
        $stmt1 = $conn->prepare("INSERT INTO dados_compradores_$email (nome, email_comprador, telefone, codigo, email) VALUES (?, ?, ?, ?, ?)");
        if ($stmt1) {
            $stmt1->bind_param("sssss", $nome, $email_comprador, $telefone, $codigo, $email);
            if ($stmt1->execute()) {
                echo "Rifa comprada com sucesso!";
            } else {
                echo "Error: " . $stmt1->error;
            }
            $stmt1->close();
        } else {
            echo "Error: Unable to prepare statement for user registration";
        }

        // Insert selected raffle numbers into the 'numbers' table
        if(isset($_POST['checkboxes'])) {
            $raffleNumbers = $_POST['checkboxes'];
            $stmt2 = $conn->prepare("INSERT INTO numeros_$email (codigo, numero_rifa, email) VALUES (?, ?, ?)");
            if ($stmt2) {
                foreach ($raffleNumbers as $raffleNumber) {
                    $stmt2->bind_param("sss", $codigo, $raffleNumber, $email);
                    if ($stmt2->execute()) {
                        

                    } else {
                        echo "Error: " . $stmt2->error;
                    }
                }
                $stmt2->close();
            } else {
                echo "Error: Unable to prepare statement for raffle number registration";
            }
        }
        $conn->close();
    }
} else {
    echo "Invalid request method";
}
?>
</center>
</body>
</html>