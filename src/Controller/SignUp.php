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
            $profilstmt = $mysqli->prepare("INSERT INTO NetflixClone.Profils (ID, NumberProfil, ProfilOne, ProfilTwo, ProfilThree, ProfilFour) VALUES (?, ?, ?, ?, ?, ?)");

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

            // Reset message every time

            if($pwd == null){
                $errorMessage = '';
                return $this->render('signup.html.twig', [
                    'error' => $errorMessage,
                ]);
            }

            if($pwd == $pwd_c){
                $hashpwd = password_hash($pwd, PASSWORD_DEFAULT);
                $stmt->bind_param("ss", $id, $hashpwd);
                $stmt->execute();

                header('Location: /login');
                mysqli_close($mysqli);
                die();
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