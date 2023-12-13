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

define('JWT_KEY', 'eyJhbGciOiJIUzI1NiJ9.eyJSb2xlIjoiQWRtaW4iLCJJc3N1ZXIiOiJJc3N1ZXIifQ.JueH6qyDWthKGswwNEUqvXGcwpk5M89g60UMLtSdjZ4');

try {
    $pdo = new PDO("mysql:host=".HOSTNAME.";dbname=".DATABASE.";charset=utf8", USERNAME, PASSWORD);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

} catch (PDOException $e) {
    echo 'Erro de conexão';
}
