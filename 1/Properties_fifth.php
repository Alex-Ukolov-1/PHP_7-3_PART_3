<?php
class Product
{
	public $go=array(20,30,40,50,60);
	public $sword=array(10,70,80,90,100,110,120);
    public static $reload=1;

	public function notify()
	{
		foreach ($this->sword as $go) 
		{
        echo $obs.=$go;
		}
		echo "<br>";
		echo $this->sword;
	}
}
$book=new Product();
echo $book->notify();
echo "<br>";
echo Product::$reload;

?>