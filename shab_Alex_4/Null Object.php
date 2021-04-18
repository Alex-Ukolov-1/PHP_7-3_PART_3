<?php
///shablons doesnt realised until the end! attansion 
//суть обработать возврат неудачной попытки возврата object
class TileForces
{
	private $units=[];
	private $x;
	private $y;

	function __construct(int $x,int $y,UnitAcquisition $acq)
	{
    $this->x=$x;
    $this->y=$y;
    $this->units=$acq->getUnits($this->x,$this->y);
	}

	public function firepower():int
	{
     $power=0;
     foreach ($this->units as $unit) 
     {
      $power+=$unit->bombardStrenght();
     }
	}
}

class UnitAcquisition
{
	function getUnits(int $x,int $y):array
	{
     $army=new Army();
     $army->addUnit(new Archer());
     $found=[new Calavary(),null,new LaserCannotUnit(),$army];
     return $found;
	}
}

$acquirer=new UnitAcquisition();
$TileForces=new TileForces(4,2,$acquirer);
$power=$TileForces->firepower();
print "firepowrt";
?>