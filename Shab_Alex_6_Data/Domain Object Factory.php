<?php

abstract class DomainObjectFactory
{
	abstract public function createObject(array $row):DomainObject;
}

class VenueObjectFactory extends DomainObjectFactory
{
	public function createObject(array $row):DomainObject
	{
		$obj=new Venue((int)$row['id'],$row['name']);
		return $obj;
	}
}

abstract class Collection implements \Iterator
 {
   protected $dofact=null;
   protected $total=0;
   protected $raw=[];

   private $result;
   private $pointer=0;
   private $objects=[];
 }

class Collection
{
	public function __construct(array $raw=[],DomainObjectFactory $dofact=null)
	{
      if(count($raw)&&! is_null($dofact))
      {
      	$this->raw=$raw;
      	$this->total=count($raw);
      }
      $this->dofact=$dofact;
	}
}

?>