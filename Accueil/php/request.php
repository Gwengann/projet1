<?php
/**
 * @Author: Thibault Napoléon <Imothep>
 * @Company: ISEN Yncréa Ouest
 * @Email: thibault.napoleon@isen-ouest.yncrea.fr
 * @Created Date: 29-Jan-2018 - 16:48:46
 * @Last Modified: 28-Apr-2020 - 15:58:54
 */

  require_once('database.php');

  // Database connexion.
  $db = dbConnect();
  if (!$db)
  {
    header('HTTP/1.1 503 Service Unavailable');
    exit;
  }
  
  // Check the request.
  $requestMethod = $_SERVER['REQUEST_METHOD'];
  $request = substr($_SERVER['PATH_INFO'], 1);
  $request = explode('/', $request);
  $requestRessource = array_shift($request);
  
  // Check the id associated to the request.
  $id = array_shift($request);
  if ($id == '')
    $id = NULL;
  $data = false;

  // Photos request.
  if ($requestRessource == 'photos')
  {
      if ($id != NULL)
          $data = dbRequestPhoto($db, intval($id));
      else
          $data = dbRequestPhotos($db);
  }
  //Comments request.
  if($requestRessource == "comment"){
    if($requestMethod == "POST" && isset($_POST["login"]) && isset($_POST["comment"]) && isset($_POST["photoId"])){
        $login = $_POST["login"];
        $text = $_POST["comment"];
        $photoId = $_POST["photoId"];
        $data = dbAddComment($db, $login, $photoId, $text);
    } else if($requestMethod == "GET" && isset($id)){
        $data = dbRequestsComments($db, $id);
    } else if($requestMethod == "PUT" && isset($id)){
        parse_str(file_get_contents("php://input"), $_PUT);
        $login = $_PUT["login"];
        $text = $_PUT["text"];
        $data = dbModifyComment($db, $id, $login, $text);
    } else if($requestMethod == "DELETE" && isset($id)){
        $login = $_GET["login"];
        $data = dbDeleteComment($db, $id, $login);
    }
}

  // Send data to the client.
  header('Content-Type: application/json; charset=utf-8');
  header('Cache-control: no-store, no-cache, must-revalidate');
  header('Pragma: no-cache');
  if ($data !== false)
  {
    header('HTTP/1.1 200 OK');
    echo json_encode($data);
  }
  else{
    header('HTTP/1.1 400 Bad Request');
  exit;
}

