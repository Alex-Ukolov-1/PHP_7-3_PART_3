<?php
class AplicationHelper
{
	public function getOptions():array
	{
		$optionfile=__DIR__."/data/woo_options.xml";
		if(! file_exists($optionfile))
		{
			throw new AppException("File with parametrs not found");
		}
		$options=simplexml_load_file($optionfile);
		$dsn=(string)$options->dsn;
	}
}

class Registry
{
	private static $testmode=false;
	private static $instance=null;

	public static function testMode(bool $mode=true)
	{
		self::$instance=null;
		self::$testmode=$mode;
	}
     
    public static function instance()
    {
    if(is_null(self::$instance))
      {
       if(self::$testmode)
        {
        self::$instance=new MockRegistry();
        }
       else
       {
       	self::$instance=new self();
       }
      }
      return self::$instance;
    }
}

class Request
{

}

class MockRegistry
{

 public function getApplicationHelper():ApplicationHelper
{
	if(is_null($this->ApplicationHelper))
	{
		$this->ApplicationHelper=new ApplicationHelper();
	}
	return $this->ApplicationHelper;
}

public function setConf($paramds)
{

}


public function setCommands($par)
{

}


 public function setRequest($request)
{
   $this->request=$request;
}

}

Registry::testMode();
print_r($mockreg=Registry::instance());


?>