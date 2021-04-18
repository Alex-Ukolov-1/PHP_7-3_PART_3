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



	interface Encoder
	{
    public function encode():string;
	}

	abstract class CommsManager
	{
		const APPT=1;
		CONST TDD=2;
		CONST CONTATC=3;
		abstract public function getHeaderText():string;
		abstract public function make(int $flag_int):Encoder;
		abstract public function getFooterText():string;
		abstract public function getAppEncoder():ApptEncoder;
        abstract public function getTtdEncoder():TdnEncoder;
        abstract public function getContactEncoder():ContactEncoder;

	}


	class BloggsCommsManager extends CommsManager
	{
		public function getHeaderText():string
		{
			return "BloggsCal верхний колонтитуль";
		}

		public function make(int $flag_int):Encoder
		{
			switch ($flag_int) {
			case self::APPT:return new BloggsApptEncoder();
			case self::CONTATC:return new BloggsContact();
			case self::TDD:return new BloggsTdnEncoder();
			}
		}

		public function getFooterText():string
		{
			return "бЛОКСКОЛЛ";
		}

		public function getAppEncoder():ApptEncoder
  	    {
  		return new BloggsApptEncoder();
     	}

     	public function getTtdEncoder():TdnEncoder
     	{
        return new BloggsApptEncoder();
     	}

        public function getContactEncoder():ContactEncoder
        {
        return new BloggsApptEncoder();
        }
	}
?>