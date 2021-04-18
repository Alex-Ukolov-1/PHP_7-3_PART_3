<?php
   abstract class Lesson 
   {
   protected $duration;
   const FIXED=1;
   const TIMED=2;
   private $costtype;

   public function __construct(int $duration,int $costtype=1)
   {
    $this->duration=$duration;
    $this->costtype=$costtype;
   }

   public function cost():int
   {
    switch($this->costtype)
    {
    	case self::TIMED:
    	return(5*$this->duration);
    	break;
    	case self::FIXED:
    	return 30;
    	break;
    	default:
    	$this->costtype=self::fixed;
    	return 30;
    }
   }

   public function chargeType():string
   {
   	switch($this->costtype)
   	{
   		case self::TIMED:
   		return "почасовая оплата";
   		break;
   		case self::FIXED:
   		return "фиксированная ставка";
   		break;
   		default:$this->costtype=self::FIXED;
   		return "фиксированная ставка";
   	}
   }

   }

   class Lecture extends Lesson
   {

   }

   class Seminar extends Lesson
   {
   	
   }
$lecture=new Lecture(5,Lesson::FIXED);
print"{$lecture->cost()} ({$lecture->chargeType()})\n";

$seminare=new Seminar(3,Lesson::TIMED);
print"{$seminare->cost()} ({$seminare->chargeType()})\n";


?>