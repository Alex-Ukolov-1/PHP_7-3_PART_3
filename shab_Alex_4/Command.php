<?php
abstract class Command
{
	abstract public function excute(CommandContext $context):bool;
}

class LoginCommand extends Command
{
	public function excute(CommandContext $context):bool
	{
		$manager=Registry::getAccessManager();
		$user=$context->get('username');
		$pass=$context->get('pass');
		$user_obj=$manager->login($user,$pass);
		if(is_null($user_obj))
		{
			$context->setError($manager->getError());
			return false;
		}
		$context->addPARAM("USER",$user_obj);
		return true;
	}
}

class ComandContext
{
	private $params=[];
	private $error="";

	public function __construct()
	{
		$this->params=$_REQUEST;
	}

	PUBLIC FUNCTION addParam(string $key,$val)
	{
		$this->params[$key]=$val;
	}

	public function get(string $key):string
	{
       if(isset($this->params[$key]))
       {
       	return $this->params[$key];
       }
       return null;
	}

	public function setError($error):string
	{
		$this->error=$error;
	}

	public function getError():string
	{
		return $this->error;
	}
}

class CommandsNotFoundException extends Exception{}

class CommandFacotory
{
private static $dir='commands';

public static function getCommand(string $action='Default'):Command
  {
  if(preg_match('/\w/',$action))
   {
    throw new Exception("not neccesaary symbols");
   }
   $class=ucfirst(strtolower($action))."Commands";
   $file=self::$dir.DIRECTORY_SEPARATOR."{$class}.php";
   if(!file_exists($file))
   {
   	throw new CommandsNotFoundException("Fail '$file' not found ");
   }
   require_once($file);
   if(!class_exists($class))
   {
   	throw new CommandsNotFoundException("Class '$file' not found ");
   }
   $cmd=new $class();
   return $cmd;
  }
}

class Controller
{
	private $context;

	public function __construct()
	{
		$this->context=new ComandContext();
	}

	public function getContext():ComandContext
	{
		return $this->context;
	}

	public function process()
	{
		$action=$this->context->get('action');
		$action=(is_null($action))?"default":$action;
		$cmd=CommandFacotory::getCommand($action);
		if(! $cmd->execute($this->context))
		{
         print "wow";
		}
		else
		{
         print "down";
		}
	}
}

$controller=new Controller();
$context=$controller->getContext();

$context->addParam('action','login');
$context->addParam('username','bob');
$context->addParam('pass','tiddles');
var_dump($context);

?>