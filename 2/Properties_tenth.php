<?php
class Expression 
{
	private static $keycount=0;
	private $key;

	public function GetKey()
	{
		if(! isset($this->key))
		{
        self::$keycount++;
        $this->key=self::$keycount;
		}
		return $this->key;
	}
}

$ded=new Expression();
$leval=new Expression();
echo $ded->GetKey();
echo $leval->GetKey();
?>