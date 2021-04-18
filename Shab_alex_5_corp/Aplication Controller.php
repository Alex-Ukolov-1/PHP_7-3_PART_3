<?php
//!!!!!!!!!! я знаю , что данный проект(по своей сути MVC) и его надо делать в разных файлах(я захотел заняться кощунством!!!!!!);
class Controller
{
	private function __construct()
	{
	 $this->reg=Registry::instance();
	}

	public function HandleRequest()
	{
		$request = $this->reg->getRequest();
		$controller= new AppController();
		$cmd=$controller->getCommand($request);
		$view=$controller->getView($request);
		$view->render($request);
	}
}

class ViewComponentCompilier
{
	private static $defaultcmd=DeafaultCommand::class;

	public function parseFILE($file)
	{
     $options=simplexml_load_file($file);
     return $this->parse($options);
	}

	public function parse(\simpleXMLElement $options):Conf
	{
     $conf=new conf();
     foreach ($options->control->command as $command)
     {
       $path=(string)$command['path'];
       $cmdstr=(string)$command['class'];
       $path=(empty($path))?"/":$path;
       $cmdstr=(empty($cmdstr))?self::$default:$cmdstr;
       $pathhobj=new ComponentDescriptor($path,$cmdstr);
       $this->ProcessView($pathhobj,0,$command);
       if(isset($command->status))&&isset($command->status['value'])
       {
         foreach($command->status as $statusel)
         {
         	$status=(string)$statusel['value'];
         	$statusval=constant(Command::class."::".$status);
         	if(is_null($statusval))
         	{
         		throw new Exception("not famous errors");
         	}
         	$this->ProcessView($pathhobj,$statusval,$statusel);
         }	
       }
      $conf->set($path,$pathjob);
     }
    return $conf;
	}

	public function ProcessView(ComponentDescriptor $pathob,int $statusval,\ simpleXMLElement $el)
	{
     if(isset($el->view)&&isset($el->view['name']))
     {
      $pathhobj->setView($statusval,new TemplateViewComponent((string)$el->view['name']));
     }
     if(isset($el->forward)&&isset($el->forward['path'])
     {
     	$pathjob->setView($statusval,new ForwardViewComponent((string)$el->forward['path']));
     }
	}
}
class ComponentDescriptor
{
	private $path;
	private static $refcmd;
	private $cmdstr;

	public function __construct(string $path,string $cmdstr)
	{
     self::refcmd=new \ReflectionClass(Command::class);
     $this->path=$path;
     $this->cmdstr=$cmdstr;
	}

	public function setView(int $status,ViewComponent $view)
	{
      $this->views[$status]=$view;
	}


	public function getView(Request $request):ViewComponent
	{
		$status=$request->getCmdStatus();
		$status=(is_null($status))?0:$status;
		if(isset($this->views[$status]))
		{
			return $this->views[$status];
		}
		if(isset($this->views[0]))
		{
			return $this->views[0];
		}
		throw new Exception("Views doesnt not found");
	}

	public function resolveCommand(string $class):Command
	{
		if(is_null($class))
		{
			throw new Exception("not famous class");
		}
		if(! class_exists($class))
		{
			throw new Exception("class not found");
		}
		$refclass=new \ReflectionClass($class);

		if(! $refclass->is_subclass_of(self::$refcmd))
		{
			throw new Exception("class not have attension to class command");
		}
		return $refclass->newInstance();
	}
}

class AppController
{
	private static $defaultcmd=DeafaultCommand::class;
	private static $defaultview="fallback";

	public function getCommand(Request $request):Command
	{
		try
		{
         $descriptor=$this->getDescriptor($request);
         $cmd=$descriptor->getCommand();
        }
		catch(AppException $e)
		{
         $request->addFeedback($e->getMessage());
         return new self::$defaultcmd();
		}
		return $cmd;
	}

	public function getView(Request $request):ViewComponent
	{
		try
		{
         $descriptor=$this->getDescriptor($request);
         $view=$descriptor->getView($request);
		}
		catch(AppException $e)
		{
        return new TemplateViewComponent(self::$defaultview);
		}
		return $view;
	}

	public function getDescriptor(Request $request):ComponentDescriptor
	{
     $reg=Registry::instance();
     $commands=$reg->getCommands();
     $path=$request->getPath();
     $descriptor=$commands->get($path);
     if(is_null($descriptor))
     {
     	throw new AppException("not found descriptor for 404");
     }
     return $descriptor;
	}

	private function setupOptions()
	{
		$vcfile=$conf->get("ViewComponentfile");
		$cparse=new ViewComponent();
		$commandandviewdata=$crparse->parseFILE($vcfile);
		$reg->setCommands($commandandviewdata);
	}
}

interface ViewComponent
{
	public function render(Request $request);
}

class TemplateViewComponent implements ViewComponent
{
	private $name=null;
	public function __construct(string $name)
	{
      $this->name=$name;
	}

	public function render(Request $request)
	{
		$reg=Registry::instance();
		$conf=$reg->getConf();
		$path=$conf->get("templatepath");
		if(is_null($path))
		{
			throw new AppException("Not found catalog shablons");
		}
		$fullpath="{$path}/{$this->name}.php";
		if(! file_exists($fullpath))
		{
			throw new AppException("not found this {$fullpath}");
		}
		include($fullpath);
	}
}

class ForwardViewComponents implements ViewComponent
{
	private $path=null;

	public function __construct($path)
	{
    $this->path=$path;
	}

	public function render(Request $request)
	{
    $request->forward($this->path);
	}
}

class httpRequest
{
	public function forward(string $path)
	{
     header("location:{$path}");
     exit;
	}
}

class CliRequest
{
	public function forward(string $path)
	{
		$_SERVER['argv'][]="path:{$path}";
		Registry::reset();
		Controller::run();
	}
}


abstract class Command
{

	const CMD_DEFAULT=0;
	const CMD_OK=1;
	const CMD_ERROR=2;
	const CMD_INSEFFICIENT_DATA=3;

	final public function __construct()
	{

	}

	public function execute(Request $request)
	{
		$status=$this->doExecute($request);
		$request->setCmdStatus($status);
	}
	abstract public function doExecute(Request $request):int;
}

class AddVenue extends Command
{
	public function doExecute(Request $request):int
	{
     $name=$request->getProperty("venue_name");

     if(is_null($name))
     {
     	$request->addFeedback("name not know!");
     	return self::CMD_INSEFFICIENT_DATA;
     }
     else
     {
     	$request->addFeedback("$name");
     	return self::CMD_OK;
     }
     return self::CMD_DEFAULT;
	}
}
?>