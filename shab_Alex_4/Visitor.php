<?php

class Army extends CompositeUnit
{
  public function bombardStrenght():int 
  {
  	$strength=0;
  	foreach ($this->units as $unit)
  	{
      $strength+=$unit->bombardStrenght();
  	}
  	return $strength;
  }
}

abstract class Unit
{
	protected $depth=0;

	public function accept(ArmyVisitor $visitor) 
	{
     $refthis=new \ReflectionClass(get_class($this));
     $method="visit".$refthis->getshortname();
     $visitor->$method($this);
	}

	protected function setDepth($depth)
	{
		$this->depth=$depth;
	}

	public function getDepth()
	{
		return $this->depth;
	}
}
 
class LasercannonUnit extends Unit
{
	public function bombardStrenght():int
	{
		return 44;
	}
}

class Archer extends Unit
{
	public function bombardStrenght():int
	{
		return 44;
	}
}


class Calavary extends Unit
{
	public function bombardStrenght():int
	{
		return 44;
	}
}

abstract class CompositeUnit extends Unit
{
	protected $units=array();

	public function addUnit(Unit $unit)
	{
      foreach ($this->units as $thisunit) 
      {
       if($unit===$thisunit)
       {
       	return;
       }
      }
    $unit->setDepth($this->depth+1);
    $this->units[]=$unit;
	}

	public function accept(ArmyVisitor $visitor)
	{
		parent::accept($visitor);
		foreach ($this->units as $thisunit)
		{
         $thisunit->accept($visitor);		
        }
	}
}

abstract class ArmyVisitor
{
	abstract public function visit(Unit $node);

	public function visitArcher(Archer $node)
	{
		$this->visit($node);
	}

	public function visitCalavary(Calavary $node)
	{
        $this->visit($node);
	}

	public function visitLaserCannonUnit(LaserCannonUnit $node)
	{
       $this->visit($node);
	}

	public function visitTroopCarrierUnit(TroopCarrierUnit $node)
	{
       $this->visit($node);
	}

	public function visitArmy(Army $node)
	{
		$this->visit($node);
	}
}

class TextDumpArmyVisitor extends ArmyVisitor
{
	private $text="";

	public function visit(Unit $node)
	{
		$txt="";
		$pad=4*$node->getDepth();
		$txt.=sprintf("%{$pad}s","");
		$txt.=get_class($node).": ";
		$txt.="war power:".$node->bombardStrenght()."<br/>";
		$this->text.=$txt;
	}

	public function getText()
	{
		return $this->text;
	}
}




$main_army=new Army();
$main_army->addUnit(new Archer());
$main_army->addUnit(new LasercannonUnit());
$main_army->addUnit(new Calavary());
$textdump=new TextDumpArmyVisitor();
$main_army->accept($textdump);
print $textdump->getText();
?>