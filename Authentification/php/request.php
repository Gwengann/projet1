<?php
require_once('database.php');

// Database connexion.
$db = dbConnect();
if (!$db)
{
  header('HTTP/1.1 503 Service Unavailable');
  exit;
}

$requestMethod = $_SERVER['REQUEST_METHOD'];
$request = substr($_SERVER['PATH_INFO'], 1);
$request = explode('/', $request);
$requestRessource = array_shift($request);
if ($requestRessource=='authenticate') {
    authenticate($db);
}else {
    verifyToken($db);
}

function authenticate($db){
    $login=$_SERVER['PHP_AUTH_USER'];
    $password=$_SERVER['PHP_AUTH_PW'] ;
    $check=dbCheckUserInjection($db,$login,$password);
    if (!$check) {
        header('HTTP/1.1 401 Unauthorized');
        exit;
    }
    $token = base64_encode(openssl_random_pseudo_bytes(12));
    dbAddToken($db, $login, $token);

    echo($token);
    exit;
}

function verifyToken($db){
    $headers = getallheaders();
    $token = $headers['Authorization'];
    if (preg_match('/Bearer (.*)/', $token, $tab))
        $token = $tab[1];
    $verif=dbVerifyToken($db,$token);
    if (!$verif) {
        header('HTTP/1.1 401 Unauthorized');
        exit;
    }
    return authenticate($db);
}