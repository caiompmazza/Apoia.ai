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
<script type=module src=main1.js></script>

<my-header></my-header>
<html>

<head>
    <title>comprar rifas</title>
</head>
<body>

<center>

<?php

$conn = mysqli_connect("localhost", "root", "", "rifas_dados");
if ($conn->connect_error) {
    die("Connection fail: " . $conn->connect_error);
}

$sql = "SELECT icone_rifa, titulo_da_rifa, descricao_da_rifa, numero_de_rifas, chave_pix, premio, imagem_premio, data_final, preco, username FROM registration WHERE username = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
       ;
        $fim = $row["numero_de_rifas"];
        $data_final = $row["data_final"];
        $icone_rifa = $row["icone_rifa"];
        $titulo_da_rifa = $row["titulo_da_rifa"];
        $descricao_da_rifa = $row["descricao_da_rifa"];
        $premio = $row["premio"];
        $imagem_premio = $row["imagem_premio"];
        $preco = $row["preco"];
        echo "<script>var data_final = '$data_final';</script>";

?>

<br>
<img src="icone_imagem\<?php echo $icone_rifa; ?>" id="icone"/>

<h1><?php echo $titulo_da_rifa; ?></h1>
<style>
                    h1{

                        font-size: 50px;
                    }
                   
                    </style>
<br>
<p><?php echo $descricao_da_rifa; ?></p>
<br>
<p>Prêmio: <?php echo $premio; ?></p>
<img src="premio_imagem\<?php echo $imagem_premio; ?>" id="icone"/>
<br>
<p>Data final: <?php echo $data_final; ?></p>
<br>

<center>
   <p id="days">00</p>
    <p>&nbsp;Dias até terminar</p> 
    
</center> 

<br>
<p>Preco: <?php echo $preco; ?></p>
<br>

<script>
var countDownDate = new Date(data_final).getTime();
var x =setInterval(function(){
    var now = new Date().getTime();
    var distance = countDownDate - now;
    var days = Math.floor(distance / (1000 * 60 * 60 * 24));
    var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
    var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
    var seconds = Math.floor((distance % (1000 * 60)) / 1000);

   document.getElementById("days").innerHTML = days;
   if(distance <0){
    clearInterval(x);
    document.getElementById("days").innerHTML = "00";
   }
},1000);
</script>
<input type="text" id="searchInput" placeholder="Search...">
<button onclick="highlightSearch()">Pesquisar</button>
</center>



<center>
<form action="connection_comprador.php" method="post" enctype="multipart/form-data" onsubmit="return validateForm()">
    <br>
    
    <h2>Preencha seus dados</h2>
    <br>

    <t><table>
        <tr>
            <td><strong>&nbsp Nome:</strong></td>
            <td><input type="text" id="nome" name="nome" ></td>
        </tr>
        <tr>
            <td><strong>&nbsp Email:</strong></td>
            <td><input type="text" id="email" name="email" ></td>
        </tr>
        <tr>
            <td><strong>&nbsp Telefone: &nbsp</strong></td>
            <td><input type="number" id="telefone" name="telefone" ></td>
        </tr>
       </table></t>
   <br>
       <br>
       
       <?php
// Fetch selected raffle numbers from the 'numbers' table
$query = "SELECT numero_rifa FROM numeros_$username";
$result_rifa = mysqli_query($conn, $query);
$marked_numbers = array();
while ($row_rifa = mysqli_fetch_assoc($result_rifa)) {
    $marked_numbers[] = $row_rifa['numero_rifa'];
}

// Generate checkboxes for raffles, excluding the already marked numbers
echo '<center><table id="numeros" border="4">';
for ($i = 1; $i <= $fim; $i++) {
    if ($i % 24 == 1) { // Start a new row after every 10 numbers
        echo '<tr>';
    }
    echo '<td id="' . $i . '"><center>'. "&nbsp" . $i . "&nbsp" . "&nbsp";
    if (!in_array($i, $marked_numbers)) {
        echo '<input type="checkbox" name="checkboxes[]" value="' . $i . '"></center></td>';
    } else {
        echo '[X]</center></td>';
    }
    if ($i % 24 == 0) { // Close the row after every 10 numbers
        echo '</tr>';
    }
}
echo '</table></center>';
?>

<script>
function highlightSearch() {
    var searchText = document.getElementById("searchInput").value.trim();
    var table = document.getElementById("numeros"); // Get the table containing the numbers
    var rows = table.getElementsByTagName("tr"); // Get all rows in the table

    // If the search text is empty, display all rows
    if (searchText === "") {
        for (var i = 0; i < rows.length; i++) {
            rows[i].style.display = "";
        }
        return; // Exit the function early
    }

    // Loop through each row
    for (var i = 0; i < rows.length; i++) {
        var cells = rows[i].getElementsByTagName("td"); // Get all cells in the row

        // Loop through each cell
        for (var j = 0; j < cells.length; j++) {
            var cell = cells[j];
            var cellNumber = cell.id;

            // Check if the cell number matches the search text
            if (cellNumber === searchText) {
                rows[i].style.display = ""; // Show the row
                break; // Exit the loop
            } else {
                rows[i].style.display = "none"; // Hide the row
            }
        }
    }
}
</script>

<style>
                    table{

                        border: 3px solid black;
                        border-collapse: collapse;
                    }
                    td,tr{
                        border: 2px solid black;
                        background-color: rgba(50,50,50,.030);

                    }

                    </style>
<br>
<br>

<button class="button" type="submit">Continuar</button>

</form>

<?php
    }
    echo "</table></center>";
} else {
            echo "<br>";
            echo "<br>";
    
    echo "<h1>Parece que não há rifas.</h1>";
            echo "<br>";
            echo "<button> <a href='logout.php'>Logout</a></button>";
            exit; // Exit the script if there are no rifas
}

$conn->close();

?>
<br>
</center>
<center>
<button> <a href="logout.php">Logout</a></button>
</center>
<br>
<script>
    function validateForm() {
        var checkboxes = document.getElementsByName("checkboxes[]");
        var isChecked = false;
        for (var i = 0; i < checkboxes.length; i++) {
            if (checkboxes[i].checked) {
                isChecked = true;
                break;
            }
        }
        if (!isChecked) {
            alert("Selecione pelo menos 1 numero");
            return false;
        }
        return true;
    }
</script>

</body>
</html>
