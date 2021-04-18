<?php
abstract class ApptEncoder
{
	abstract public function encode():string;
}

class BloggsApptEncoder extends ApptEncoder
{
	public function encode():string
	{
		return "Данные о встрече закодированы в формате BloggsCal";
	}
}

class MegaApptEncoder extends ApptEncoder
{
	public function encode():string
	{
	return "Данные о встрече закодированы в формате MegaCal";
    }
}
abstract class CommsManager
{
 abstract public function getHeaderText():string;
 abstract public function getAppEncoder():ApptEncoder;
 abstract public function getFooterText():string;
}
  class BloggsCommsManeger extends CommsManager
  {
  	public function getHeaderText():string
  	{
     return "верхний";
  	}
  	public function getAppEncoder():ApptEncoder
  	{
  		 return new BloggsApptEncoder();
  	}
  	public function  getFooterText():string
  	{
  		 return "нижний";
  	}
  }




class AppConfig
{
	private static $instance;
	private $commsManager;

	private function __construct()
	{
      $this->init();
	}

	private function init()
	{
     switch(Settings::$COMMSTYPE)
     {
      case 'MEGA':
      $this->commsManager=new MegaCommsManager();
      break;
      default:
      $this->commsManager=new BloggsCommsManager();
     }
	}

	public static function getInstance():AppConfig
	{
    if(empty(self::$instance))
       {
       self::$instance=new self();
       }
    return self::$instance;
	}

	public function getCommsManager():commsManager
	{
		return $this->commsManager;
	}
}

$commsMgr=AppConfig::getInstance()->getCommsManager();
print $commsManager->getApptEncoder()->encode();
?>