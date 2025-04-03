<?php
$host = "localhost"; 
$username = "root";  
$password = "vini1234A@"; 
$dbname = "cadastro"; 

// Conectar ao banco de dados
$conn = new mysqli($host, $username, $password, $dbname);

// Verificar conexão
if ($conn->connect_error) {
    die("Erro ao conectar ao banco de dados: " . $conn->connect_error);
}

// Verificar se o formulário foi enviado
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Sanitizar e validar os dados do formulário
    $name = htmlspecialchars(trim($_POST['name']), ENT_QUOTES, 'UTF-8');
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $password = trim($_POST['password']);
    $confirm_password = trim($_POST['confirm_password']);

    // Validar email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "<script>alert('E-mail inválido!'); window.history.back();</script>";
        exit();
    }

    // Verificar se as senhas coincidem
    if ($password !== $confirm_password) {
        echo "<script>alert('As senhas não coincidem. Tente novamente!'); window.history.back();</script>";
        exit();
    }

    // Criar hash seguro da senha
    $hashed_password = password_hash($password, PASSWORD_BCRYPT);

    // Verificar se o e-mail já existe
    $query = "SELECT email FROM usuarios WHERE email = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        echo "<script>alert('E-mail já cadastrado! Escolha outro.'); window.history.back();</script>";
        exit();
    }

    // Fechar a verificação antes de reutilizar o statement
    $stmt->close();

    // Preparar a inserção
    $query = "INSERT INTO usuarios (nome, email, senha) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($query);

    if ($stmt === false) {
        echo "<script>alert('Erro ao preparar a consulta!'); window.history.back();</script>";
        exit();
    }

    // Associar parâmetros e executar
    $stmt->bind_param("sss", $name, $email, $hashed_password);

    if ($stmt->execute()) {
        echo "<script>alert('Cadastro realizado com sucesso!'); window.location.href='login.html';</script>";
    } else {
        echo "<script>alert('Erro ao cadastrar: " . $stmt->error . "'); window.history.back();</script>";
    }

    // Fechar conexão
    $stmt->close();
    $conn->close();
}
?>
