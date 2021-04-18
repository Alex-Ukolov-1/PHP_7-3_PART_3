<?php

try
  {
  $venuemapper=new VenueMapper();
  $venues=$venuemapper->findall();
  }

catch(\Exception $e)
  {
   include('Page Controller.php');
   exit(0);
  }
?>
<html>
<head>
	<title>total list</title>
</head>
<body>
	 <h1>list of cafes</h1>
	 <?php foreach ($venues as $venue)?>
	 <?php print $venue->getName();?><br/>
	<?php }?>
</body>


<?php
abstract class PageController
{
	abstract public function process();

	public function __construct()
	{
		$this->reg=Registy::instance();
	}

	public function init()
	{
		if(isset($_SERVER['REQUEST_METHOD']))
		{
         $request=new HttpRequest();
		}
		else
		{
         $request=new CliRequest();
		}
		$this->req->setRequest($request);
	}

	public function forward(string $resource)
	{
     $request=$this->getRequest();
     $request->forward($resource);
	}

	public function render(string $resource , Request $request)
	{
       include($resource);
	}

	public function getRequest()
	{
		return $this->reg->getRequest();
	}
}


class AddVenueController extends PageController
{
	public function process()
	{
		$request=$this->getRequest();

		try
		{
			$name=$request->getProperty('venua_name');
			if(is_null($request->getProperty('submitted')))
			{
				$request->addfeedback("show the nameof this!");
				$this->render(__DIR__.'/view/add_venue.php',$request);
				return;
			}
			elseif(is_null($name))
			{
             $request->addfeedback("name the build must be pointed");
             $this->render(__DIR__.'/view/add_venue.php',$request);
             return;
			}
			else
			{
				$this->forward('listvenues.php');
			}
		}
		catch(Exception $e)
		{
			$this->render(__DIR__.'/view/error.php',$request);
		}
	}
}

$addvenue=new AddVenueController();
$addvenue->init();
$addvenue->process();

?>