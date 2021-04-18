<?php
   abstract class Unit
   {
    abstract public function addUnit(Unit $unit);
    abstract public function removeUnit(Unit $unit);
    abstract public function bombardStrenght():int;
   }

   Class Archer extends Unit 
   {
   	public function bombardStrenght():int
   	{
   		return 4;
   	}
   	public function addUnit(Unit $unit)
   	{
     throw new Exception(get_class($this)."Error Processing Request");
     
   	}
    public function removeUnit(Unit $unit)
    {
     throw new Exception(get_class($this)."Error Processing Request");
    }
   }

   class LaserCannonUnit extends Unit
   {
   	public function bombardStrenght():int
   	{
   		return 44;
   	}
   	public function addUnit(Unit $unit)
   	{
     throw new Exception("Error Processing Request");
     
   	}
    public function removeUnit(Unit $unit)
    {
     throw new Exception("Error Processing Request");
    }
   }

   class Army extends Unit
   {
   	private $units=[];

   	public function addUnit(Unit $unit)
   	{
   		if(in_array($unit,$this->units,true))
   		{
   			return;
   		}
   		$this->units[]=$unit;
   	}

   	public function removeUnit(Unit $unit)
   	{
   	  $idx=array_search($unit,$this->units,true);
   	  if(is_int($idx))
   	  {
   	  	array_splice($this->units,$idx,1,[]);
   	  }
   	}

   	public function bombardStrenght():int
   	{
   		$ret=0;
   		foreach ($this->units as $unit)
   		{
   			$ret+=$unit->bombardStrenght();
   		}
   		return $ret;
   	}
   }

  $main_army=new Army();
  
  $main_army->addUnit(new Archer());

  $main_army->addUnit(new LaserCannonUnit());

  $sub_army=new Army();

  $sub_army->addUnit(new Archer());

  $sub_army->addUnit(new Archer());

  $sub_army->addUnit(new Archer());

  $main_army->addUnit($sub_army);

  print "атакующая сила:{$main_army->bombardStrenght()}";
?>