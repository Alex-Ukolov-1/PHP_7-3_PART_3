<?php
class Reload
{

	public $request;
	public $dead;
	public $values;

	public function setName($dead)
	{
     $this->dead=$dead;
	}

	public function getName():string
	{
     return $this->dead="300";
	}


}
$request=1;
$dead=2;
$values=3;
$request=new Reload();
$request->setName($request);
echo($request->getName());

?>