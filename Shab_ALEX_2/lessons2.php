<?php
abstract class Lesson 
{
	private $duration;
	private $costStrategy;

	public function __construct(int $duration,CostStrategy $strategy)
	{
     $this->duration=$duration;
     $this->costStrategy=$strategy;
	}

	public function cost():int
	{
		return $this->costStrategy->cost($this);
	}

	public function chargeType():string
	{
		return $this->costStrategy->chargeType();
	}

	public function getDuration():int
	{
		return $this->duration;
	}
}

    class Lecture extends Lesson
    {

    }

    class Seminar extends Lesson
   {

   }

  abstract class CostStrategy
  {
  	abstract public function cost(Lesson $lesson):int;
  	abstract public function chargeType():string;
  }

  class TimedCostStrategy extends CostStrategy
  {
  	public function cost(Lesson $lesson):int
  	{
  		return($lesson->getDuration()*5);
  	}

  	public function chargeType():string
  	{
  		return "почасовая оплата";
  	}
  }


  class FixedCostStrategy extends CostStrategy
  {
    public function cost(Lesson $lesson):int
    {
    	return 30;
    }
    
    public function chargeType():string
    {
    	return "фиксирванная ставка";
    }

  }

  $lesson[]=new Seminar(4,new TimedCostStrategy());
  $lesson[]=new Lecture(4,new FixedCostStrategy());
  foreach ($lesson as $less) 
  {
   print "оплата за занятие{$less->cost()}.";
   print "тип оплаты: {$less->chargeType()}\n";
  }
?>