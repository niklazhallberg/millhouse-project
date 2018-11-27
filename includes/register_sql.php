<?php
session_start(); 
include 'database_connection.php';


$first_name = $_POST["first_name"];
$last_name = $_POST["last_name"];
$date_of_birth = $_POST["date_of_birth"];
$email = $_POST["email"];
$username = $_POST["username"];
$password = $_POST["password"];

//stores password as cryptated in database
$hashed_password = password_hash($password, PASSWORD_DEFAULT);

//checks if all input fields are filled in
if(!empty($_POST["first_name"]) && !empty($_POST["last_name"]) && !empty($_POST["email"]) && !empty($_POST["date_of_birth"]) && !empty($_POST["username"]) && !empty($_POST["password"])) {

    //gets number of rows in database, if any, where the username exists in users
    $statement = $pdo->prepare("SELECT COUNT(username) AS user_exists FROM users WHERE username = :username");
    $statement->execute([":username" => $username]);

    $fetched_row = $statement->fetch();

    //if user exists, send error message
    if ((int)$fetched_row["user_exists"] >= 1) {

        header('Location: ../views/register.php?error=Username already exists. Please log in.');

    } else {
        //registeres user, inserts details in database
        $register_user_to_database = $pdo->prepare("INSERT INTO users (username, password, email, first_name, last_name, date_of_birth) VALUES (:username, :password, :email, :first_name, :last_name, :date_of_birth)");

        $register_user_to_database->execute([":username" => $username, ":password" => $hashed_password, ":email" => $email, ":first_name" => $first_name, ":last_name" => $last_name, ":date_of_birth" => $date_of_birth]);

        //select all from registered user
        $select_registered_user = $pdo->prepare("SELECT * FROM users WHERE username = :username");
        $select_registered_user->execute([":username" => $username]);

        $fetched_user = $select_registered_user->fetch();
        //Save fetched user in session
        $_SESSION["username"] = $fetched_user["username"];
        $_SESSION["user_id"] = $fetched_user["id"];

        
        header('Location: ../index.php');
    } 
    
    
} else {
    //if required had been erased from html - and not all input fields are filled in - populate GET with error message
    header('Location: ../views/register.php?error=Please fill in all fields to continue.');
}