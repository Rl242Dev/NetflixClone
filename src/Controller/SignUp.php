<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use mysqli;

class SignUp extends AbstractController
{
    public function signupFunction(): Response
    {
        $errorMessage = '';

        $mysqli = new mysqli("127.0.0.1", "rl242", "31#Nigi2", "NetflixClone");

        if($mysqli === false){
            die("ERROR: Could not connect. " . mysqli_connect_error());
        }

        if($_SERVER["REQUEST_METHOD"] == "POST"){
            $stmt = $mysqli->prepare("INSERT INTO NetflixClone.Users (ID, PWD) VALUES (?, ?)");

            $pwd = $_POST["pwd"];
            $pwd_c = $_POST["pwd-c"];
            $id = $_POST["id"];

            $pwdSplitted = explode(" ", $pwd);

            if(count($pwdSplitted) < 1){
                $errorMessage = 'Space Detected!';
                return $this->render('signup.html.twig', [
                    'error' => $errorMessage,
                ]);
            }

            if($pwd == $pwd_c){

                $query = $mysqli->prepare("SELECT ID FROM NetflixClone.Users WHERE ID = ?");
                $query->bind_param("s", $id);
                $query->execute();
                $result = $query->get_result();

                if($result == false){
                    $hashpwd = password_hash($pwd, PASSWORD_DEFAULT);
                    $stmt->bind_param("ss", $id, $hashpwd);
                    $stmt->execute();
                }
                else{
                    $errorMessage = 'User already exist';
                    return $this->render('signup.html.twig', [
                        'error' => $errorMessage,
                    ]);
                }
            }
            else{
                $errorMessage = 'Passwords Don\'t Match';
                return $this->render('signup.html.twig', [
                    'error' => $errorMessage,
                ]);
            }
        }

        return $this->render('signup.html.twig', [
            'error' => $errorMessage,
        ]);
    }
}