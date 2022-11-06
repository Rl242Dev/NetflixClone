<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use mysqli;

class Login extends AbstractController
{
    public function loginFunction(): Response
    {
        $errorMessage = '';

        $mysqli = new mysqli("127.0.0.1", "rl242", "31#Nigi2", "NetflixClone");

        if($mysqli === false){
            die("ERROR: Could not connect. " . mysqli_connect_error());
        }

        if($_SERVER['REQUEST_METHOD'] == "POST"){
            $id = $_POST['id'];
            $pwd = $_POST['pwd'];

            $stmt = $mysqli->prepare("SELECT * FROM NetflixClone.Users WHERE ID = ?");
            $stmt->bind_param("s", $id);

            $stmt->execute();

            $result = $stmt->get_result();
            if($result == false){
                $errorMessage = 'User Doesn\'t exist';
                return $this->render('login.html.twig', [
                    'error' => $errorMessage,
                ]);
            }
            else{
                while($row = $result->fetch_assoc()){
                    if(password_verify($pwd, $row['PWD'])){
                        if(session_id() == '') {
                            session_start();

                            $_SESSION['islogged'] = true;
                            $_SESSION['id'] = $id;
                            $_SESSION['pwd'] = $pwd;

                            header('Location: /homepage');
                            mysqli_close($mysqli);
                            die();
                        }else{
                            header('Location: /homepage');
                            mysqli_close($mysqli);
                            die();
                        }
                    }
                    else{
                        $errorMessage = 'Password Incorrect';
                        return $this->render('login.html.twig', [
                            'error' => $errorMessage,
                        ]);
                    };
                }
            }

        }
        // Must return something to skip Response Error

        return $this->render('login.html.twig', [
            'error' => $errorMessage,
        ]);
    }
}