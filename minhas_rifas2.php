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
    <title>minhas rifas</title>
</head>
<body>
   <wbr>
<center>
   
    <br>
<?php
$conn = mysqli_connect("localhost", "root", "", "rifas_dados");
if ($conn->connect_error) {
    die("Connection fail: " . $conn->connect_error);
}

$sql = "SELECT titulo_da_rifa, username FROM registration WHERE username =?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();



if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $titulo_da_rifa=$row["titulo_da_rifa"];
    }
}  else {
            echo "<h1>Parece que não há rifas.</h1>";
            echo "<br>";
            echo "<button> <a href='logout.php'>Logout</a></button>";
            exit; // Exit the script if there are no rifas
        }
?>
 <h1><?php echo $titulo_da_rifa; ?></h1>
 <style>
                    h1{

                        font-size: 50px;
                    }
                   
                    </style>


<?php
$conn = mysqli_connect("localhost", "root", "", "rifas_dados");
if ($conn->connect_error) {
    die("Connection fail: " . $conn->connect_error);
}

$sql = "SELECT nome, email_comprador, telefone, codigo FROM dados_compradores_$username";
$result = $conn->query($sql);

$dados_compradores = array(); // Store dados_compradores data in an array

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $dados_compradores[$row["codigo"]] = $row;
    }
}
?>

<?php
$conn = mysqli_connect("localhost", "root", "", "rifas_dados");
if ($conn->connect_error) {
    die("Connection fail: " . $conn->connect_error);
}

$sql = "SELECT numero_rifa, codigo FROM numeros_$username ";
$result = $conn->query($sql);

$numeros_rifa = array();
$codigos_numbers = array();

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $numeros_rifa[] = $row["numero_rifa"];
        $codigos_numbers[$row["codigo"]][] = $row["numero_rifa"]; // Store numbers for each codigo
    }
}
?>

<?php
$conn = mysqli_connect("localhost", "root", "", "rifas_dados");
if ($conn->connect_error) {
    die("Connection fail: " . $conn->connect_error);
}

$sql = "SELECT numero_de_rifas, username FROM registration WHERE username = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $numero_de_rifas = $row["numero_de_rifas"];
    }
}
?>
<?php
// Get the current page URL
$currentURL = "http://localhost/site_rifas(flask)/comprar_rifa.php";


?>
<br>
<p>Copiar link para compra das rifas:</p>

<!-- Display a button to copy the URL to the clipboard -->
<button onclick="copyURL()">Copy URL</button>

<br>
<script>
function copyURL() {
    var copyText = "<?php echo $currentURL; ?>";
    navigator.clipboard.writeText(copyText)
        .then(function() {
            alert("URL copied to clipboard!");
        })
        .catch(function() {
            alert("Failed to copy URL to clipboard.");
        });
}
</script>
<br>

<button onclick="exportToExcel()">Exportar para Excel</button>

    <script>
        function exportToExcel() {
            let table = document.getElementById("dados");
            let html = table.outerHTML;
            let blob = new Blob([html], { type: "application/vnd.ms-excel" });
            let url = window.URL.createObjectURL(blob);
            let a = document.createElement("a");
            a.href = url;
            a.download = "<?php echo $titulo_da_rifa; ?>.xls";
            a.click();
        }
    </script>
<br>
  <br>
    <input type="text" id="searchInput" placeholder="Search...">
    <button onclick="highlightSearch()">Pesquisar</button>
<br>
<br>    
<table id="dados" border="4">
    <tr>
        <th>&nbsp;Numero&nbsp;</th>
        <th>&nbsp;Nome&nbsp;</th>
        <th>&nbsp;Email&nbsp;</th>
        <th>&nbsp;Telefone&nbsp;</th>
        <th>&nbsp;Numero&nbsp;</th>
        <th>&nbsp;Nome&nbsp;</th>
        <th>&nbsp;Email&nbsp;</th>
        <th>&nbsp;Telefone&nbsp;</th>
        <th>&nbsp;Numero&nbsp;</th>
        <th>&nbsp;Nome&nbsp;</th>
        <th>&nbsp;Email&nbsp;</th>
        <th>&nbsp;Telefone&nbsp;</th>
    </tr>
    <?php
    // Initialize an empty array to store the index data
    $index = [];

    // Loop through each raffle number
    for ($i = 1; $i <= $numero_de_rifas; $i++) {
        // Start a new row for every third number or the first number
        if (($i - 1) % 3 == 0) {
            if ($i != 1) {
                echo "</tr>"; // Close the previous row except for the first row
            }
            echo "<tr>"; // Start a new row
        }

        // Initialize variables to store data for the current raffle number
        $nome = '';
        $email = '';
        $telefone = '';

        // Check if the current raffle number is associated with any user data
        foreach ($codigos_numbers as $codigo => $numeros) {
            if (in_array($i, $numeros)) {
                // Assign user data to variables
                $nome = $dados_compradores[$codigo]["nome"];
                $email = $dados_compradores[$codigo]["email_comprador"];
                $telefone = $dados_compradores[$codigo]["telefone"];
                break; // Exit the loop once data is found
            }
        }

        // Output the raffle number in a cell
        echo "<td><center>$i</center></td>";

        // Output user data in cells
        echo "<td>" . ($nome ? "&nbsp;$nome&nbsp;" : "") . "</td>";
        echo "<td>" . ($email ? "&nbsp;$email&nbsp;" : "") . "</td>";
        echo "<td>" . ($telefone ? "&nbsp;$telefone&nbsp;" : "") . "</td>";

        // Store cell data in the index array
        $index[] = [$i, $nome, $email, $telefone];
    }

    // Close the last row
    echo "</tr>";
    ?>
</table>


<script>
    var index = <?php echo json_encode($index); ?>;

    function highlightSearch() {
        var searchText = document.getElementById("searchInput").value.trim().toLowerCase();
        var table = document.getElementById("dados");
        var rows = table.getElementsByTagName("tr");

        for (var i = 1; i < rows.length; i++) {
            var row = rows[i];
            var cells = row.getElementsByTagName("td");
            var rowMatches = false;

            // Iterate over each cell in the row
            for (var j = 1; j < cells.length; j++) { // Start from index 1 to skip the first cell (which contains the raffle number)
                var cellText = cells[j].textContent.trim().toLowerCase();

                // Check if the cell text contains the search text
                if (cellText.includes(searchText)) {
                    rowMatches = true;
                    break;
                }
            }

            // Show or hide the row based on the search result
            row.style.display = rowMatches ? "" : "none";
        }
    }
</script>



<br>
<button> <a href="logout.php">Logout</a></button>
<center>
      <style>
                    table, th{

                        border: 3px solid black;
                        border-collapse: collapse;
                        background-color: rgba(50,50,50,.03)
                    }
                    td,tr{
                        border: 2px solid black;
                         background-color: rgba(50,50,50,.03);

                    }

                    </style>
    <br>

</body>
</html>
