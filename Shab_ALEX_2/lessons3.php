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

   class RegistrationMgr
   {
   public function register(Lesson $lesson)
    {
   	$notifier=Notifier::getNotifier();
   	$notifier->inform("Новое занятие:стоимость-({$lesson->cost()})");
    }
   }

   abstract class Notifier
   {
   	public static function getNotifier():Notifier
   	{
   		if(rand(1,2)===1)
   		{return new MailNotifier();}
   	    else
   	    {return new TextNotifier();}
   	}
   	abstract public function inform($message);
   }

   class MailNotifier extends Notifier
   {
   	public function inform($message)
   	{
      print "Уведомлние по электронной почте:{$message}\n";
   	}
   }

   class TextNotifier extends Notifier
   {
   	public function inform($message)
   	{
   		print"текстовое уведомление:{$message}\n";
   	}
   }

   $lesson=new Seminar(4,new TimedCostStrategy());
   $lesson1=new Lecture(4,new FixedCostStrategy());
   $mgr=new RegistrationMgr();
   $mgr->register($lesson);
   $mgr->register($lesson1);
   ?>