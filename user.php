<?php


class User
{
    private $id;
    public $_login;
    public $_email;
    public $_firstname;
    public $_lastnanme;
    public $_password;
    public $_password2;


    /**
     * ma fonction register sert à créer un user en BDD
     */

    public function register($_login, $_email, $_firstname, $_lastname, $_password, $_passwordConfirm)
    {
        session_start();
        $bdd = mysqli_connect("localhost", "root", "", "classes");

        $login = htmlspecialchars($_login); //creation d'un variable permettant d'eviter les injection sql
        $email = htmlspecialchars($_email); //creation d'un variable permettant d'eviter les injection sql
        $firstname = htmlspecialchars($_firstname);
        $lastname = htmlspecialchars($_lastname);
        $password = hash('sha512', $_password);


        if (!empty($login) && !empty($email) && !empty($firstname) && !empty($lastname) && !empty($_password) && !empty($_passwordConfirm)) { // si tout les champs ne sont pas vide 

            $searchdoublonsmail = "SELECT email FROM utilisateurs WHERE email = '$email'";
            $reqRowmail = mysqli_query($bdd, $searchdoublonsmail);

            if (mysqli_num_rows($reqRowmail) == 0) { //si il y'a 0 utilisateur correspondant au login ecrit

                if ($_passwordConfirm == $_password) { //si le password2 est strictement egale a password

                    $insert = "INSERT INTO utilisateurs(login, email, firstname, lastname, password) VALUES('$login', '$email', '$firstname', '$lastname', '$password')";
                    $insertinto = mysqli_query($bdd, $insert);
                    $_SESSION['comptecrée'] = "<font color='green>'Votre Compte est créé !!! <a href=\"connexion.php\">Se connecter !</a></font>"; //message qui confirme l'incription
                    
                    return '
                    <table>
                        <thead>
                            <th>Login</th>
                            <th>Password</th>
                            <th>Email</th>
                            <th>Firstname</th>
                            <th>Lastname</th>
                        </thead>
                        <tbody>
                            <tr>
                                <td>' . $login . '</td>
                                <td>' . $email . '</td>
                                <td>' . $firstname . '</td>
                                <td>' . $lastname . '</td>
                                <td>' . $password . '</td>
                            </tr>
                        </tbody>
                    </table>';
                } else {
                    $_SESSION['fail'] = '<font color="red">les passwords ne concordent pas !!!</font>'; //indque quel erreur enpeche l'incripetion
                }
            } else {
                $_SESSION['fail'] = '<font color="red">Cette email est dejà utilisé !</font>'; //indque quel erreur enpeche l'incripetion
            }
        } else {
            $_SESSION['fail'] = '<font color="red">Il manque des champs !</font>'; //indque quel erreur enpeche l'incripetion
        }
    }

    public function connect($_login, $_password)
    {
        $bdd = mysqli_connect("localhost", "root", "", "classes");

        $login = htmlspecialchars($_login); //creation d'un variable permettant d'eviter les injection sql
        $password = sha1($_password); //enrypte le mot de passe

        if (!empty($login) && !empty($password)) { //si l'input login et password ne sont pas vide

            $request = "SELECT * FROM utilisateurs WHERE login = $login && password = $password";
            $userinfo = mysqli_query($bdd, $request);
            $userexist = mysqli_num_rows($userinfo);
            $allinfo = mysqli_fetch_all($userinfo);

            if ($userexist == 1) {

                foreach($allinfo as $userinfoconnect){
                    $id = $userinfoconnect['id'];
                    $login = $userinfoconnect['login'];
                    $email = $userinfoconnect['email'];
                    $firstname = $userinfoconnect['firstname'];
                    $lastname = $userinfoconnect['lastname'];

                }
                $this->id = $id;
                $this->login = $login;
                $this->email = $email;
                $this->firstname = $firstname;
                $this->lastname = $lastname;

                session_start();
                $_SESSION['login'] = $login;
                $_SESSION['connect'] = $id;
                
            } else {
                $_SESSION['fail'] = '<font color="red">Login inexsistant ou Password incorrect !</font>'; //indque quel erreur enpeche la connexion
            }
        } else {
            $_SESSION['fail'] = '<font color="red"> Il manque des champs !</font>'; //indque quel erreur enpeche la connexion
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
        $bdd = mysqli_connect('localhost', 'root', '', 'classes');
        mysqli_query($bdd, "DELETE FROM `utilisateurs` WHERE `login`='$login'");
        
        echo 'bien supprime';
    } 
    
    public function update($login, $password, $email, $firstname, $lastname)
    {
        $user = $_SESSION['id'];
        $bdd = mysqli_connect('localhost', 'root', '', 'classes');
        mysqli_query($bdd, "UPDATE utilisateurs SET login='$login', password ='$password',  email ='$email', firstname ='$firstname', lastname ='$lastname' WHERE id = '$user'");
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
        $bdd = mysqli_connect('localhost', 'root', '', 'classes');
        $stmt = mysqli_query($bdd, "SELECT * FROM utilisateurs WHERE id = '$user'");
        $req = mysqli_fetch_all($stmt, MYSQLI_ASSOC);
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
        $bdd = mysqli_connect('localhost', 'root', '', 'classes');
        $stmt = mysqli_query($bdd, "SELECT login FROM utilisateurs WHERE id = '$user'");
        $req = mysqli_fetch_all($stmt, MYSQLI_ASSOC);
        foreach($req as $value){
            $login = $value['login'];
        }
        return $login;
    }

    public function getEmail()
    {
        $user = $_SESSION['id'];
        $bdd = mysqli_connect('localhost', 'root', '', 'classes');
        $stmt = mysqli_query($bdd, "SELECT email FROM utilisateurs WHERE id = '$user'");
        $req = mysqli_fetch_all($stmt, MYSQLI_ASSOC);
        foreach($req as $value){
            $email = $value['email'];
        }
        return $email;
    }

    public function getFirstname()
    {
        $user = $_SESSION['id'];
        $bdd = mysqli_connect('localhost', 'root', '', 'classes');
        $stmt = mysqli_query($bdd, "SELECT firstname FROM utilisateurs WHERE id = '$user'");
        $req = mysqli_fetch_all($stmt, MYSQLI_ASSOC);
        foreach($req as $value){
            $firstname = $value['firstname'];
        }
        return $firstname;
    }

    public function getLastname()
    {
        $user = $_SESSION['id'];
        $bdd = mysqli_connect('localhost', 'root', '', 'classes');
        $stmt = mysqli_query($bdd, "SELECT lastname FROM utilisateurs WHERE id = '$user'");
        $req = mysqli_fetch_all($stmt, MYSQLI_ASSOC);
        foreach($req as $value){
            $lastname = $value['lastname'];
        }
        
        return $lastname;
    }
}

$login ='test2';
$password = 'test2';
$email = 'test2';
$firstname = 'test2';
$lastname ='test2';
$test = new User();
$test->connect($login, $password, $email, $firstname, $lastname);

?>
