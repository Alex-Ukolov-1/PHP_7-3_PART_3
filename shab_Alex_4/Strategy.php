<?php
abstract class Question
{
	protected $promt;
	protected $marker;

	public function __construct(string $promt,Marker $marker)
	{
		$this->promt=$promt;
		$this->marker=$marker;
	}

	public function mark(string $response):bool
	{
     return $this->marker->mark($response);
	}
}

class AVQuestion extends Question
{

}

class TextQuestion extends Question
{

}

abstract class Marker
{
	protected $test;

	public function __construct(string $test)
	{
    $this->test=$test;
	}
	abstract public function mark(string $response):bool;
}


class MarkLogical extends Marker
{
	public function mark(string $response):bool
	{
		return($this->test==$response);
	}
}

class MatchMarker extends Marker
{
	public function mark(string $response):bool
	{
		return($this->test==$response);
	}
}


class RegexpMarker extends Marker
{
	public function mark(string $response):bool
	{
		return(preg_match("$this->test",$response)===1);
	}
}


$markers=[new RegexpMarker("err"),new MatchMarker("five"),new MarkLogical('input equals"five"')];


foreach ($markers as $marker)
{
	print get_class($marker)."<br/>";
	$question=new TextQuestion("how much",$marker);
	foreach (["five","four"] as $response)
	{
    print " answer: $response ";
    if($question->mark($response))
       {
       print " Right ";
       }
    else (print " not right ");
	}
}
?>