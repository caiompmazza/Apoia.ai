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

    <center>
        <br><br><br><br><br><br><br><br><br><br><br><br>
       <h1>Crie, Venda e Compre Rifas</h1>
<h2>totalmente online</h2>
<style>
                    h1{

                        font-size: 80px;
                    }
                    h2{

                        font-size: 50px;
                    }
                    </style>
    </center>    

</html>
