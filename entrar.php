<?php
$host = "localhost";   // Servidor do banco de dados
$username = "root";    // Usuário do banco de dados
$password = "vini1234A@"; // Senha do banco de dados
$dbname = "cadastro"; // Nome do banco de dados

// Conectar ao banco de dados MySQL usando mysqli
$conn = new mysqli($host, $username, $password, $dbname);

session_start(); // Inicia a sessão

if (password_verify($senha, $hashed_password)) {
    $_SESSION['email'] = $email; // Armazena o e-mail na sessão
    header("Location: dashboard.php"); // Redireciona para uma página interna
    exit();
} else {
    echo "Credenciais inválidas. Tente novamente.";
}
session_start();
if (!isset($_SESSION['email'])) {
    header("Location: Entrar.html"); // Redireciona para o login se não estiver logado
    exit();
}


// Verificando se a conexão foi bem-sucedida
if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Coletar e validar os dados do formulário
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $senha = trim($_POST['senha']);

    if (empty($email) || empty($senha)) {
        die("Preencha todos os campos.");
    }

    // Preparar a consulta SQL para evitar SQL Injection
    $query = "SELECT senha FROM usuarios WHERE email = ?";
    $stmt = $conn->prepare($query);
    
    if (!$stmt) {
        die("Erro na preparação da consulta: " . $conn->error);
    }

    // Associar parâmetros e executar a consulta
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        // Obter o hash da senha armazenada
        $stmt->bind_result($hashed_password);
        $stmt->fetch();

        // Verificar a senha com password_verify()
        if (password_verify($senha, $hashed_password)) {
            echo "<script>alert('Login bem-sucedido!'); window.location.href='dashboard.php';</script>";
            exit();
        } else {
            echo "<script>alert('Senha incorreta!'); window.history.back();</script>";
            exit();
        }
    } else {
        echo "<script>alert('Usuário não encontrado!'); window.history.back();</script>";
        exit();
    }

    // Fechar conexão
    $stmt->close();
    $conn->close();
}
?>

