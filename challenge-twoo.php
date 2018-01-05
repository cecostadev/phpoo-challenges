<?php
/**
 * Challenge2: make this terrible code safe []https://github.com/wearebase/base-php-challenges/blob/master/challenges/4.php]
 * 
 * $username = @$_GET['username'] ? $_GET['username'] : '';
 *$password = @$_GET['password'] ? $_GET['password'] : '';
 *$password = md5($password);
 *$pdo = new PDO('sqlite::memory:');
 *$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
 *$pdo->exec("DROP TABLE IF EXISTS users");
 *$pdo->exec("CREATE TABLE users (username VARCHAR(255), password VARCHAR(255))");
 *$rootPassword = md5("secret");
 *$pdo->exec("INSERT INTO users (username, password) VALUES ('root', '$rootPassword');");
 *$statement = $pdo->query("SELECT * FROM users WHERE username = '$username' AND password = '$password'");
 *if (count($statement->fetchAll())) {
 *    echo "Access granted to $username!<br>\n";
 *} else {
 *    echo "Access denied for $username!<br>\n";
 *}
*/

echo "<!doctype html>";

//I change the global variable GET for POST, we can't pass this important parameters in URL
if(empty($_POST['username']) or empty($_POST['password']))
{
    exit("User or Pass cannot be empty");
}

//Just GET for POST
$username = $_POST['username'];
$password = $_POST['password'];
$password = md5($password);

$pdo = new PDO('sqlite::memory:');

$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$pdo->exec("DROP TABLE IF EXISTS users");
$pdo->exec("CREATE TABLE users (username VARCHAR(255), password VARCHAR(255))");

//Using ':' to protect for SQL Injection
$query = "INSERT INTO users (username, password) VALUES (:username, :password)";    

//Preparing the query
$stmt = $pdo->prepare($query);

//Finishing the prepared statment
$stmt->bindParam(':username', $username, PDO::PARAM_STR);
$stmt->bindParam(':value', $password , PDO::PARAM_STR);

//Verifying if the insert has success
if($stmt->execute())
{
    echo "Insert Successfull!";
} else {
    echo "Something was wrong!";
}

//Using ':' to protect for SQL Injection
$select = "SELECT * FROM users WHERE username = :username AND password = :password";

//Finishing the prepared statment
$stmt->bindParam(':username', $username, PDO::PARAM_STR);
$stmt->bindParam(':value', $password , PDO::PARAM_STR);

$stmt = $pdo->execute($query);

//Think, we need only one user, so, is not safe get more than one
if ($stmt->rowCount() == 1) {
    echo "Access granted to $username!<br>\n";
} else {
    echo "Access denied for $username!<br>\n";
}