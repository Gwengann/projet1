<?php
require_once('constantes.php');

//Connexion à la base de donnée
function dbConnect()
  {
    try
    {
      $db = new PDO('mysql:host='.DB_SERVER.';dbname='.DB_NAME.';charset=utf8',
        DB_USER, DB_PASSWORD);
      $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
    }
    catch (PDOException $exception)
    {
      error_log('Connection error: '.$exception->getMessage());
      return false;
    }
    return $db;
  }

  //Fonction requête des photos
function dbRequestPhotos($db)
  {
    try
    {
      $request = 'SELECT id, small FROM photos';
      $statement = $db->prepare($request);
      $statement->execute();
      $result = $statement->fetchAll(PDO::FETCH_ASSOC);
    }
    catch (PDOException $exception)
    {
      error_log('Request error: '.$exception->getMessage());
      return false;
    }
    return $result;
  }

  //Fonction requête d'une photo
function dbRequestPhoto($db, $id)
  {
    try
    {
      $request = 'SELECT id, title, large FROM photos WHERE id=:id';
      $statement = $db->prepare($request);
      $statement->bindParam(':id', $id, PDO::PARAM_INT);
      $statement->execute();
      $result = $statement->fetch(PDO::FETCH_ASSOC);
    }
    catch (PDOException $exception)
    {
      error_log('Request error: '.$exception->getMessage());
      return false;
    }
    return $result;
  }

  //Fonction ajout d'un commentaire
function dbAddComment($db, $login, $photoId, $text)
  {
    try
    {
      $request = 'INSERT INTO comments(userLogin, photoId, comment) VALUES(:userLogin, :photoId, :comment)';
      $statement = $db->prepare($request);
      $statement->bindParam(':userLogin', $login, PDO::PARAM_STR, 20);
      $statement->bindParam(':photoId', $photoId, PDO::PARAM_INT);
      $statement->bindParam(':comment', $text, PDO::PARAM_STR, 80);
      $statement->execute();
    }
    catch (PDOException $exception)
    {
      error_log('Request error: '.$exception->getMessage());
      return false;
    }
    return true;
  }

  //Fonction requête d'un commentaire
function dbRequestsComments($db, $photoId){
    try
    {
      $request = 'SELECT * FROM comments WHERE photoId=:photoId';
      $statement = $db->prepare($request);
      $statement->bindParam(':photoId', $photoId, PDO::PARAM_INT);
      $statement->execute();
      $result = $statement->fetchAll(PDO::FETCH_ASSOC);
    }
    catch (PDOException $exception){
      error_log(('Request error: '.$exception->getMessage()));
      return false;
    }
    return $result;
  }

  //Fonction modification d'un commentaire
function dbModifyComment($db, $commentId, $login, $text){
    try
    {
      $request = 'UPDATE comments SET comment=:text WHERE id=:id AND userLogin=:login';
      $statement = $db->prepare($request);
      $statement->bindParam(':text', $text, PDO::PARAM_STR);
      $statement->bindParam(':id', $commentId, PDO::PARAM_INT);
      $statement->bindParam(':login', $login, PDO::PARAM_STR);
      $statement->execute();
    }
    catch (PDOException $exception){
      error_log('Request error : '.$exception->getMessage());
      return false;
    }
    return true;
  }

  //Fonction suppression d'un commentaire
  
function dbDeleteComment($db, $commentId, $login)
  {
    try
    {
      $request = 'DELETE FROM comments WHERE id=:id AND userLogin=:login';
      $statement = $db->prepare($request);
      $statement->bindParam(':id', $commentId, PDO::PARAM_INT);
      $statement->bindParam(':login', $login, PDO::PARAM_STR, 20);
      $statement->execute();
    }
    catch (PDOException $exception)
    {
      error_log('Request error: '.$exception->getMessage());
      return false;
    }
    return true;
  }
