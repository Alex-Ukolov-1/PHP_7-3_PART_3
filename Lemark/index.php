<?php
class Dangerous
{
	function download()
	{
$login = filter_var(trim($_POST['login']),FILTER_SANITIZE_STRING);

$name = filter_var(trim($_POST['name']),FILTER_SANITIZE_STRING);

$password = filter_var(trim($_POST['password']),FILTER_SANITIZE_STRING);


if(mb_strlen($login)<5||mb_strlen($login)>90)
{
	echo "Недопустимые значения логина!";
	exit();
}else if(mb_strlen($name)<3||mb_strlen($name)>50)
{
	echo "Недопустимые значения! имени";
	exit();
}else if(mb_strlen($password)<3||mb_strlen($password)>50)
{
	echo "Недопустимые значения! пароля";
	exit();
}

$mysql=new mysqli('alex.loc','root','root','registor');
$mysql->query("INSERT INTO `users`(`login`,`name`,`pass`) VALUES('$login','$name','$password')");

$mysql->close();
header('Location: /файлсайт(1).php');
    }
}
$ball=new Dangerous();
$ball->download();
?>