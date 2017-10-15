<?php

class UserController
{
    
    public function actionRegister()
    {
        $name = '';
        $email = '';
        $password = '';
        $result = false;
        
        if(isset($_POST['submit'])){
            $name = $_POST['name'];
            $email = $_POST['email'];
            $password = $_POST['password'];
            
            $errors = false;
            
            if(!User::checkName($name)){
                $errors[] = 'Имя не должно быть корочк 2-х символов';
            }
            
            if(!User::checkEmail($email)){
                $errors []= 'Неправильный email';
            }
            
            if(!User::checkPassword($password)){ 
                $errors[] = 'Пароль не должен быть корочк 6 символов';
            }
            
            if(User::checkEmailExists($email)){
                $errors[] = 'Такой email уже используется';
            }
            
            if($errors == false){
                
                $result = User::register($name, $email, $password);
            }
        }
        
        require_once ROOT.'/views/user/register.php';
        
        return true;
    }
    
    public function actionLogin(){
        $email='';
        $password = '';
        
        if(isset($_POST['submit'])){
            $email = $_POST['email'];
            $password = $_POST['password'];
            
            $errors = false;
            
            if(!User::checkEmail($email)){
                $errors[] = 'Ivalid email';
            }
            
            if(!User::checkPassword($password)){
                $errors[] = 'Пароль не должен быть короче 6 симоволов';
            }
            
            $userId = User::checkUserData($email, $password);
            
            if($userId == false){
                $errors[] = 'Invalid data';
            } else {
                User::auth($userId);
                
                header("Location: /cabinet/");
            }
        }
        
        require_once ROOT . '/views/user/login.php';
        
        return true;
    }
    
    public function actionLogout(){
        
        unset($_SESSION['user']);
        header("Location: /");
        
    }
    
}

