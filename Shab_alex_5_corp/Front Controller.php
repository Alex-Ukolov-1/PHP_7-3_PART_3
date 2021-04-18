<?php
//!!!!!!!!!! я знаю , что данный проект(по своей сути MVC) и его надо делать в разных файлах(я захотел заняться кощунством!!!!!!);
require("Registry.php");
class Controller
{
	private $reg;

	private function __construct()
	{
		$this->reg=Registry::instance();
	}

	public static function run()
	{
		$instance=new Controller();
		$instance->init();
		$instance->handleRequest();
	}

	private function init()
	{
		$this->reg->getApplicationHelper()->init();
	}


	private function handleRequest()
	{
		$request=$reg->getRequest();
		$resolver=new CommandResolver();
		$cmd=$resolver->getCommand($request);
		$cmd->execute($request);
	}
}


Controller::run();

class ApplicationHelper
{
private $config=__DIR__."woo.ini";
private $reg;

public function __construct()
  {
   $this->reg=Registry::instance();
  }


  public function setRequest(Request $request)
{
   $this->request=$request;
}

public function init()
  {
  $this->setupOptions();
  if(isset($_SERVER['REQUEST_METHOD']))
    {
    $request=new HttpRequest();
    }
  else
    {
    $request=new ClientRequest();
    }
    $this->reg->setRequest($request);
  }

private function setupOptions()
  {
  	if(!file_exists($this->config))
  	{
  		throw new Exception("File configuration not found ");
  	}
  	$options=parse_ini_file($this->config,true);
  	$conf=new Conf($options['config']);
  	$this->reg->setConf($conf);
  	$commands=new Conf($options['commands']);
    $this->reg->setCommands($commands);
  }



public function getRequest()
{
if(is_null($this->request))
  {
  throw new \AppException("Object the typeof Request doesn't found");
  }
return $this->request;
}

public function getApplicationHelper():ApplicationHelper
{
	if(is_null($this->ApplicationHelper))
	{
		$this->ApplicationHelper=new ApplicationHelper();
	}
	return $this->ApplicationHelper;
}

public function setConf(Conf $conf)
{
  $this->conf=$conf;
}

public function getConf():Conf
{
 if(is_null($this->conf))
 {
 	$this->conf=new conf();
 }
 return $this->conf;
}

public function setCommands(conf $commands)
{
$this->commands=$commands;	
}

public function getCommands():conf
{
	return $this->commands;
}

}

class Conf
{
public function setConf($paramds)
{

}

}

class CommandResolver
{
     private static $refcmd=null;
     private static $defaultcmd=DefaultCommand::class;

     public function __construct()
     {
     	self::$refcmd=new \ReflectionClass(Command::class);
     }

     public function getCommand(Request $request):Command
     {
      $reg->Registry::instance();
      $commands=$reg->getCommands();
      $path=$Request->getpath();

      $class=$commands->get($path);

      if(is_null($class))
      {
       $request->addFeedBack("doesnt not found this path");
       return new self::$defaultcmd();
      }

      if(! class_exists($class))
      {
      $request->addFeedBack("doesnt not found this path");
       return new self::$defaultcmd();
      }

      $refclass=new \ReflectionClass($class);
      if(! $refclass->issubclassof(self::$refcmd))
      {
      	$request->addFeedBack("wow");
      	return new self::$defaultcmd();
      }
      return $refclass->newInstance();
     }
}

abstract class Command
{
  final public function __construct()
  {
  
  }

  public function execute(Request $request)
  {
   $this->doExcecute($request);
  }

  abstract public function doExcecute(Request $request);
}

abstract class Requestt
{
 protected $properties;
 protected $feedback=[];
 protected $path="/";

 public function __construct()
 {
 	$this->init();
 }

 abstract public function init();

 public function setPath(string $path)
 {
   $this->path=$path;
 }

 public function GetPath():string
 {
   return $this->path;
 }

 public function getProperty(string $key)
 {
 	if(isset($this->properties[$key]))
 	{
 		return $this->properties[$key];
 	}
 	return null;
 }

 public function setProperty(string $key,$val)
 {
  $this->properties[$key]=$val;
 }

 public function addFeedBack(string $msg)
 {
 	array_push($this->feedback,$msg);
 }

 public function getFeedBackString($deparator="\n"):string
 {
 	return implode($seprator,$this->feedback);
 }

 public function clearFeedBack()
 {
 	$this->feedback=[];
 }
}

class HttpRequest extends Requestt
{
 public function init()
 {
 	$this->properties=$_REQUEST;
 	$this->path=$_SERVER['PATH_INFO'];
 	$this->path=(empty($this->path))?"/":$this->path;
 }
}

class CliRequest extends Requestt
{
public function init()
  {
   $args=$_SERVER['argv'];
   foreach ($args as $arg)
    if(preg_match("",$args,$matches))
    {
    	$this->path=$matches[1];
    }
    else
    {
    	if(strpos($arg,'='))
    	{
    		list($key,$val)=explode("=",$arg);
    		$this->setProperty($key,$val);
    	}
    }
    $this->path=(empty($this->path)) ? "/":$this->path;
  }
}


class DefaultCommand extends Command 
{
      public function doExcecute(Request $request)
      {
      	$request->addFeedBack("welcome!");
      }
}

?>