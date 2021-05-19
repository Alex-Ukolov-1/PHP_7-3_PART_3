<?php
class Product
{
	public $go=array(30,40,50,60);

	public function notify()
	{
		foreach ($this->go as $value) 
		{
        echo $obs.=$value;
		}
		echo "<br>";
		return $this->go[]=$value;
	}
}
$book=new Product();
echo $book->notify();
?>