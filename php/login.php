<?php 
    session_start();
    include_once "config.php";
    $login = mysqli_real_escape_string($conn, $_POST['login']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $_SESSION['login'] = $login;
    if(!empty($login) && !empty($password)){
        $sql = mysqli_query($conn, "SELECT * FROM users WHERE login = '{$login}'");
        if(mysqli_num_rows($sql) > 0){
            $row = mysqli_fetch_assoc($sql);
            $enc_pass = $row['pass'];
            if($password == $enc_pass){
                $_SESSION['id'] = $row['id'];
                echo "success";
            }else{
                echo  "Email или Пароль не верны!";
            }
        }else{
            echo "$login - Такого пользователя не существует!";
        }
    }
?>