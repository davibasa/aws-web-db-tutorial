<?php 
include "../inc/dbinfo.inc"; 
ini_set('display_errors', 1);
error_reporting(E_ALL);

$connection = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_DATABASE);
if (mysqli_connect_errno()) echo "Erro na conexão ao MySQL: " . mysqli_connect_error();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $nome = mysqli_real_escape_string($connection, $_POST['nome'] ?? '');
  $preco = mysqli_real_escape_string($connection, $_POST['preco'] ?? '');
  $data_cadastro = mysqli_real_escape_string($connection, $_POST['data_cadastro'] ?? '');
  if ($nome && $preco && $data_cadastro) {
    $query = "INSERT INTO PRODUTOS (nome, preco, data_cadastro) VALUES ('$nome', '$preco', '$data_cadastro')";
    if (!mysqli_query($connection, $query)) echo "<p>Erro ao adicionar produto.</p>";
  }
}

?>
<html>
<body>
<h1>Cadastro de Produtos</h1>
<form method="POST">
  Nome: <input type="text" name="nome" required maxlength="100"><br>
  Preço: <input type="number" step="0.01" name="preco" required><br>
  Data Cadastro: <input type="date" name="data_cadastro" required><br>
  <input type="submit" value="Cadastrar">
</form>
<h2>Lista de Produtos</h2>
<table border="1">
  <tr>
    <th>ID</th><th>Nome</th><th>Preço</th><th>Data Cadastro</th>
  </tr>
<?php
$result = mysqli_query($connection, "SELECT id, nome, preco, data_cadastro FROM PRODUTOS");
while($row = mysqli_fetch_assoc($result)) {
  echo "<tr>";
  echo "<td>".$row['id']."</td>";
  echo "<td>".$row['nome']."</td>";
  echo "<td>".$row['preco']."</td>";
  echo "<td>".$row['data_cadastro']."</td>";
  echo "</tr>";
}
mysqli_free_result($result);
mysqli_close($connection);
?>
</table>
</body>
</html>
