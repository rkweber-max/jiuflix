<?php
// Porta 8001
$port = $_SERVER['PORT'];
$host = $_SERVER['HOST'];
$protocol = $_SERVER['PROTOCOL'];
$url = $protocol . '://' . $host . ':' . $port;

echo $url;