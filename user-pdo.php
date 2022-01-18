<?php

class User{

private $id;
public $login;
public $email;
public $firstname;
public $lastname;

private $bdd;

public function __construct()
{
}

public function register($login, $password, $email, $firstname, $lastname)
{
    
        $db_user = 'root';
        $db_pass = '';
        $dbh = new PDO ('mysql:host=localhost;dbname=classes', $db_user, $db_pass);
        
    $stmt = $dbh->prepare("INSERT INTO `utilisateurs` (`login`, `password`, `email`, `firstname`, `lastname`) VALUES ('$login', '$password', '$email', '$firstname', '$lastname'");
    $stmt->execute();
    echo 'bien inscrit';
}

public function connect($login, $password)
{

    $db_user = 'root';
    $db_pass = '';
    $dbh = new PDO ('mysql:host=localhost;dbname=classes', $db_user, $db_pass);
    $stmt = $dbh->prepare("SELECT * FROM utilisateurs WHERE login = '$login' AND password = '$password'");
    $stmt->execute();

    if($stmt->rowCount() == 1 ){
        $req = $stmt->fetchAll(PDO::FETCH_ASSOC);
        foreach($req as $value){
        $id = $value['id'];
        $login = $value['login'];
        $email = $value['email'];
        $firstname = $value['firstname'];
        $lastname = $value['lastname'];
        
        $this->id = $id;
        $this->login = $login;
        $this->email = $email;
        $this->firstname = $firstname;
        $this->lastname = $lastname;
        
        session_start();
        $_SESSION['login'] = $login;
        $_SESSION['id'] = $id;
        echo 'bien co';
        }
    }
    else{
        echo 'introuvable';
    }   
    
}

public function disconnect()
{
    session_start();
    session_destroy();
    echo 'bien deco';
}


public function delete($login)
{
    $db_user = 'root';
    $db_pass = '';
    $dbh = new PDO ('mysql:host=localhost;dbname=classes', $db_user, $db_pass);
    $stmt = $dbh->prepare("DELETE FROM `utilisateurs` WHERE `login`='$login'");
    $stmt->execute();
    
    echo 'bien supprime';
} 

public function update($login, $password, $email, $firstname, $lastname)
{
    $user = $_SESSION['id'];
    $db_user = 'root';
    $db_pass = '';
    $dbh = new PDO ('mysql:host=localhost;dbname=classes', $db_user, $db_pass);
    $stmt = $dbh->prepare("UPDATE utilisateurs SET login='$login', password ='$password',  email ='$email', firstname ='$firstname', lastname ='$lastname' WHERE id = '$user'");
    $stmt->execute();
    echo 'bien modifié';
}

public function isConnected()
{
    $result = null;
    if(isset($_SESSION['login']))
    {
        $result = true;
    }
    else
    {
        $result = false;
    }

    return $result;
}

public function getAllInfos()
{
    $user = $_SESSION['id'];
    $db_user = 'root';
    $db_pass = '';
    $dbh = new PDO ('mysql:host=localhost;dbname=classes', $db_user, $db_pass);
    $stmt = $dbh->prepare("SELECT * FROM utilisateurs WHERE id = '$user'");
    $stmt->execute();
    $req = $stmt->fetchAll(PDO::FETCH_ASSOC);
    foreach($req as $value){
        $login = $value['login'];
        $password = $value['password'];
        $email = $value['email'];
        $firstname = $value['firstname'];
        $lastname = $value['lastname'];
    }
    

    return array($login, $password, $email, $firstname, $lastname);
}

public function getLogin()
{
    $user = $_SESSION['id'];
    $db_user = 'root';
    $db_pass = '';
    $dbh = new PDO ('mysql:host=localhost;dbname=classes', $db_user, $db_pass);
    $stmt = $dbh->prepare("SELECT login FROM utilisateurs WHERE id = '$user'");
    $stmt->execute();
    $req = $stmt->fetchAll(PDO::FETCH_ASSOC);
    foreach($req as $value){
        $login = $value['login'];
    }
    return $login;
}

public function getEmail()
{
    $user = $_SESSION['id'];
    $db_user = 'root';
    $db_pass = '';
    $dbh = new PDO ('mysql:host=localhost;dbname=classes', $db_user, $db_pass);
    $stmt = $dbh->prepare("SELECT email FROM utilisateurs WHERE id = '$user'");
    $stmt->execute();
    $req = $stmt->fetchAll(PDO::FETCH_ASSOC);
    foreach($req as $value){
        $email = $value['email'];
    }
    return $email;
}

public function getFirstname()
{
    $user = $_SESSION['id'];
    $db_user = 'root';
    $db_pass = '';
    $dbh = new PDO ('mysql:host=localhost;dbname=classes', $db_user, $db_pass);
    $stmt = $dbh->prepare("SELECT firstname FROM utilisateurs WHERE id = '$user'");
    $stmt->execute();
    $req = $stmt->fetchAll(PDO::FETCH_ASSOC);
    foreach($req as $value){
        $firstname = $value['firstname'];
    }
    return $firstname;
}

public function getLastname()
{
    $user = $_SESSION['id'];
    $db_user = 'root';
    $db_pass = '';
    $dbh = new PDO ('mysql:host=localhost;dbname=classes', $db_user, $db_pass);
    $stmt = $dbh->prepare("SELECT lastname FROM utilisateurs WHERE id = '$user'");
    $stmt->execute();
    $req = $stmt->fetchAll(PDO::FETCH_ASSOC);
    foreach($req as $value){
        $lastname = $value['lastname'];
    }
    
    return $lastname;
}

}
?>