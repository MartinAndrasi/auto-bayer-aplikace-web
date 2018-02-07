<?php
session_start();
ob_start();

define("HOST", "localhost");     // The host you want to connect to.
define("USER", "autobayerc");    // The database username.
define("PASSWORD", "gu5xiSih");    // The database password.
define("DATABASE", "autobayerc");    // The database name.

class Db{
  public $link;

  function __construct($host,$user,$pass,$name){
    $options=array(
      PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
      PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"
      );
    $this->link = @new PDO("mysql:host=$host;dbname=$name",$user,$pass,$options);
  }

}
try{
  $db = new Db(HOST,USER,PASSWORD,DATABASE);
  } catch(Exception $e) {
  echo "Tabulku nelze vypsat<br />\n";
  echo $e->getMessage(),"\n";
}


function getUserIP()
{
    $client  = @$_SERVER['HTTP_CLIENT_IP'];
    $forward = @$_SERVER['HTTP_X_FORWARDED_FOR'];
    $remote  = $_SERVER['REMOTE_ADDR'];

    if(filter_var($client, FILTER_VALIDATE_IP))
    {
        $ip = $client;
    }
    elseif(filter_var($forward, FILTER_VALIDATE_IP))
    {
        $ip = $forward;
    }
    else
    {
        $ip = $remote;
    }

    return $ip;
}

$user_ip = getUserIP();


$statement = $db->link->prepare("INSERT INTO monitoring_aplikace (ip) VALUES(:ip)");
$statement->execute([
    "ip" => $user_ip
 ]);

header('Location:https://play.google.com');
exit;
