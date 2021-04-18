<?php

class Dowm
{
       public static function down($path,$really)
       {
       var_dump($down=$really." ".$rel=$path);
       }
       public static function ded()
       {
       	echo 'hellow!';
       }
}


class Reider
{
	public $path;
	public $really;
	   function __construct($path=null,$really=null)
	   {
	   	$this->path=$path;
	   	$this->really=$really;
        $this->leek=Dowm::down($path,$really);
	   }
}

$down=new Reider("Alex will be"," a programmist");
?>