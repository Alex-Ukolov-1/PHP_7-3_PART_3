<?php

class Preferences
{   //класс создаёт сам внутри себя объекты
	private $props=[];
	private static $instanse;
	private function __construct()
	{

	}

	public static function getInstance()
	{
		if(empty(self::$instanse))
		{
			self::$instanse=new Preferences();
		}
		return self::$instanse;
	}

	public function setProperty(string $key,string $val)
	{
     $this->props[$key]=$val;
	}

	public function getProperty(string $key):string
	{
      return $this->props[$key];
    }
}
$pref=Preferences::getInstance();
$pref->setProperty("name","иван");
unset($pref);//delete parametr
$pref2=Preferences::getInstance();
print $pref2->getProperty("name")."\n";
?>