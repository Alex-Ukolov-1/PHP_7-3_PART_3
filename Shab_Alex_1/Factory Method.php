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
 $mgr=new BloggsCommsManeger();
 print $mgr->getHeaderText();
 print $mgr->getAppEncoder()->encode();
 print $mgr->getFooterText();

?>