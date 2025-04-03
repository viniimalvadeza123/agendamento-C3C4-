<?php
$host = "localhost";
$username = "root";
$password = "vini1234A@";
$dbname = "cadastro"; // Verifique o nome do banco!

// Criando conexão com MySQL
$conn = new mysqli($host, $username, $password, $dbname);

// Verificando erro de conexão
if ($conn->connect_error) {
    die("Erro: Não foi possível conectar ao banco de dados. " . $conn->connect_error);
}

// Mensagem de sucesso (apenas para testes, remova em produção)
echo "✅ Conexão bem-sucedida com o banco de dados!";

// Fechar a conexão
$conn->close();
?>
