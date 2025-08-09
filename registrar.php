<?php
// registrar.php
$host = 'localhost';
$usuario = 'root';
$senhaDB = '';           // senha do usuário "root" do MySQL se houver
$nomeBanco = 'los_proxy'; // crie este banco no phpMyAdmin

$conn = new mysqli($host, $usuario, $senhaDB, $nomeBanco);
if ($conn->connect_error) {
    die('Falha na conexão: ' . $conn->connect_error);
}

$nome  = $_POST['nome'] ?? '';
$email = $_POST['email'] ?? '';
$senha = $_POST['senha'] ?? '';

if ($nome && $email && $senha) {
    // Usar senhas criptografadas com password_hash
    $senhaHash = password_hash($senha, PASSWORD_DEFAULT);

    $stmt = $conn->prepare(
        "INSERT INTO usuarios (nome, email, senha) VALUES (?, ?, ?)"
    );
    $stmt->bind_param('sss', $nome, $email, $senhaHash);

    if ($stmt->execute()) {
        echo 'Conta criada com sucesso!';
    } else {
        echo 'Erro ao criar conta: ' . $stmt->error;
    }
    $stmt->close();
} else {
    echo 'Preencha todos os campos.';
}

$conn->close();
?>
