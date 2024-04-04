<?php
session_start();

// Redirect if session already exists
if(isset($_SESSION['email'])) {
    header("Location: home1.php");
    exit;
}

$connect = mysqli_connect("localhost", "root", "", "rifas_dados") or die("connection failed");

if (!empty($_POST['save'])) {
    $email = $_POST['em'];
    $password = $_POST['pw'];

    // Use prepared statements to prevent SQL injection
    $query = "SELECT email, password, username FROM signup WHERE email=? AND password=?";
    $stmt = $connect->prepare($query);
    $stmt->bind_param("ss", $email, $password); // Binding only email and password
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        // Login successful
        $row = $result->fetch_assoc(); // Fetch the row from the result
        $_SESSION['email'] = $row['email']; // Assign email to session
        $_SESSION['username'] = $row['username']; // Assign username to session
        header("Location: home1.php");
        exit;
    } else {
        // Login failed
        echo "Login failed";
    }
}
?>

<html>
<head>
    <br><br><br><br><br><br><br><br><br>
    <meta charset="UTF-8">
    <title>Login</title>
</head>
<body>
    <center>
    <h1>Login</h1>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">  
        <table>
            <tr>
                <td><strong>Email</strong></td>
                <td><input type="text" name="em" maxlength="100" required/></td>
            </tr>
            <tr>
                <td><strong>Senha</strong></td>
                <td><input type="password" name="pw" id="password" maxlegnth="100" required/></td>
                <td><img src="eye-close.svg" id="eyeicon" alt="olho-fechado" width="30" height="30"></td>
            </tr>
        </table>
        <br>
        <input type="submit" name="save" value="Continuar"/>
    </form> 

    <script>
        let eyeicon = document.getElementById("eyeicon");
        let password = document.getElementById("password");

        eyeicon.onclick = function(){
            if(password.type == "password"){
                password.type = "text";
                eyeicon.src="eye-open.svg";
            } else {
                password.type = "password";
                eyeicon.src = "eye-close.svg";
            }
        }
    </script>

    <button><a href="signup.html">Sign-up</a></button>

  </center>

</body> 
</html>
