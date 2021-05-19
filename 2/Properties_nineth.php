<?php

class Observer
{
	private $observers=[];
	public function attach(Observer $observer)
	{
      $this->observers[]=$observer;
	}
	public function notify()
	{
		foreach ($this->observers as $obs)
		{
			$obs->update($this);
		}
	}
	public function update($observable)
	{
		$status=$Observable;
		print __Class__.":reworking this thing";
	}
}
$login=new Observer();
$down=new Observer();
$down->attach($login);
print_r($down->notify());
?>