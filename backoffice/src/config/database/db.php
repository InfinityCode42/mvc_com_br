<?php
if($_SERVER['HTTP_HOST'] == 'www.novastack.tech') {
    define('HOSTNAME', '193.203.175.53');
    define('PORT', '3306');
    define('USERNAME', 'u483821734_root');
    define('PASSWORD', 'ToBzdLV#XMQy8Aes');
    define('DATABASE', 'u483821734_novastack');
}

if($_SERVER['SERVER_NAME'] == 'localhost') {
    define('HOSTNAME', 'localhost');
    define('PORT', '3306');
    define('USERNAME', 'root');
    define('PASSWORD', 'root');
    define('DATABASE', 'novastack_com_br');
}

try {
    $pdo = new PDO("mysql:host=".HOSTNAME.";dbname=".DATABASE.";charset=utf8", USERNAME, PASSWORD);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

} catch (PDOException $e) {
    echo 'Erro de conexão';
}
