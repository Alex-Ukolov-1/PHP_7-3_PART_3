<?php


interface Observable
	{
		public function attach(Observer $observer);
		public function detach(Observer $observer);
		public function notify();
	}

class Login implements Observable
{
	private $observers=[];
	private $storage;

	const LIGON_USER_UNKNOWN=1;
	const LOGIN_WRONG_PASS=2;
	const LOGIN_ACCESS=3;
	public function attach(Observer $observer)
	{
      $this->observers[]=$observer;
	}

	public function detach(Observer $observer)
	{
     $this->observers=array_filter($this->observers,function($a)use($observer){return (!($a===$observer));});
	}

	public function notify()
	{
		foreach ($this->observers as $obs)
		{
			$obs->$update($this);
		}
	}

}

interface observer
{
	public function update(Observable $observable);
}

class LoginAnalytics implements Observer
{
	public function update(Observable $observable)
	{
		$status=$Observable->getStatus();
		print __Class__.":reworking this thing";
	}
}

abstract class loginObserver implements Observer
{
	private $login;
	public function __construct(Login $login)
	{
    $this->login=$login;
    $login->attach($this);
	}

	public function update(Observable $observable)
	{
     if($observable===$this->login)
     {
     	$this->doUpdate($observable);
     }
	}

	abstract public function doUpdate(Login $login);
}


class SecurityMonitor extends loginObserver
{
	public function doUpdate(Login $login)
	{
      $status=$login->setStatus();
      if($status[0]==Login::LOGIN_WRONG_PASS)
      {
      	print __Class__.":sent a letter to administrator"."<br/>";
      }
	}
}

class GeneralLogger extends loginObserver
{
	public function doUpdate(Login $login)
	{
		$status=$login->getStatus();
		print __Class__.":registration in system reestr";
	}
}

class ParthnershipTool extends loginObserver
{
	public function doUpdate(Login $login)
	{
		$status=$login->getStatus();
		print __Class__.":sent a cookie if addres in price";
	}
}

$login=new login();
new SecurityMonitor($login);
new GeneralLogger($login);
new ParthnershipTool($login);
print_r(get_class_vars('Login'));

?>