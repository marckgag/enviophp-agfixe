<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Coletando os dados do formulário
    $nome = strip_tags(trim($_POST["name"]));
    $telefone = strip_tags(trim($_POST["telefone"]));
    $email = filter_var(trim($_POST["email"]), FILTER_SANITIZE_EMAIL);
    $assunto = strip_tags(trim($_POST["subject"]));
    $mensagem = trim($_POST["message"]);

    // Verifica se todos os campos obrigatórios foram preenchidos
    if (empty($nome) || empty($telefone) || empty($email) || empty($assunto) || empty($mensagem) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        // Configura uma resposta de erro
        http_response_code(400);
        echo "Por favor, preencha todos os campos obrigatórios e use um e-mail válido.";
        exit;
    }

    // Definindo o destinatário
    $destinatario = "falecomafixe@gmail.com";

    // Montando o conteúdo do e-mail
    $conteudo_email = "Nome: $nome\n";
    $conteudo_email .= "Telefone: $telefone\n";
    $conteudo_email .= "Email: $email\n";
    $conteudo_email .= "Assunto: $assunto\n";
    $conteudo_email .= "Mensagem:\n$mensagem\n";

    // Definindo os cabeçalhos do e-mail
    $headers = "From: $nome <$email>";

    // Enviando o e-mail
    if (mail($destinatario, $assunto, $conteudo_email, $headers)) {
        // Configura uma resposta de sucesso
        http_response_code(200);
        echo "Mensagem enviada com sucesso!";
    } else {
        // Configura uma resposta de erro
        http_response_code(500);
        echo "Ocorreu um erro ao enviar sua mensagem. Tente novamente mais tarde.";
    }
} else {
    // Se não for uma solicitação POST, retorna um erro
    http_response_code(403);
    echo "Este método de solicitação não é suportado.";
}
?>
