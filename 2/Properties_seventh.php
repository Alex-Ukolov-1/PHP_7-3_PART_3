<?php
class Red
{
      
}
class Down
{
	public $storage;
	public function __construct()
	{
		if(isset($storage))
     $storage->storage=new Red($red);
	}

	public function attach(Red $down)
	{  
		if(!isset($down))
        return $this->storage->attach($down);
	}
}
$load=new Red();
$new=new Down();
$new->attach($load);
var_dump($new);
echo "<br>";
var_dump($dod=$new->attach($load));
?>