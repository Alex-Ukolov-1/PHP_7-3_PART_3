<?php
class NastyBoss
{
	private $employee=[];
	public function addEmployee(Employee $employee)
	{
     $this->employee[]=$employee;
	}

	public function projectFails()
	{
		if(count($this->employee))
		{
			$emp=array_pop($this->employee);
			$emp->fire();
		}
	}
}
class CluedUp extends Employee
{
	public function fire()
	{
		print "{$this->name}:я вызову адвоката";
	}
}

class Minion extends Employee
{
	public function fire()
	{
		print "{$this->name}:я уберу со стола";
	}
}


abstract class Employee
{
	protected $name;
	private static $types = ['Minion','CluedUp','WellConnected'];

	public static function recruit(string $name)
	{
		$num=rand(1,count(self::$types))-1;
		$class=__NAMESPACE__."\\".self::$types[$num];
		return new $class($name);
	}

	public function __construct(string $name)
	{
     $this->name=$name;
	}

	abstract public function fire();
}


class WellConnected extends Employee
{
	public function fire()
	{
		print "{$this->name}:я позвоню папе\n";
	}

}
$boss=new NastyBoss();
$boss->addEmployee(Employee::recruit("IGOR"));
$boss->addEmployee(Employee::recruit("ALEX"));
$boss->addEmployee(Employee::recruit("DON"));
$boss->projectFails();
$boss->projectFails();
$boss->projectFails();

?>