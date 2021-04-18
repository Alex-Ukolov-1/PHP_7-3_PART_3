<?php
//class registry in another files
abstract class Mapper 
{
	protected $pdo;

	public function __contruct()
	{
		$reg=Registry::instance();
		$this->pdo=$reg->getPdo();
	}

	public function find(int $id):DomainObject
	{
		$this->selectsmt()->execute([$id]);
		$row=$this->selectsmt()->fetch();
		$this->selectsmt()->closeCursor();

		if(! is_array($row))
		{
         return null;
		}

		if(! isset($row['id']))
		{
         return null;
		}

		$object=$this->createObject($row);
		return $object;
	}

	public function createObject(array $raw):DomainObject
	{
		$obj=$this->DoCreateObject($raw);
		return $obj;
	}


	public function insert(DomainObject $obj)
	{
     $this->doInsert($obj);
	}

	abstract public function update(DomainObject $object);
	abstract protected function DoCreateObject(array $raw):DomainObject;
	abstract protected function doInsert(DomainObject$object);
	abstract protected function selectsmt();
	abstract protected function targetClass():string;
}

class VenueMapper extends Mapper
{
	private $selectStmt;
	private $updateStmt;
	private $insertStmt;

	public function __contruct()
	{
		parent::__contruct();
		$this->selectStmt=$this->pdo->prepare("SELECT * FROM venue Where id=?");
		$this->updateStmt=$this->pdo->prepare("UPDATE venue SET name=?,id=? where id=?");
		$this->insertStmt=$this->pdo->prepare("INSERT INTO venue (name) VALUES(?)");
	}

	protected function targetClass():string
	{
		return Venue::class;
	}

	public function getCollection(array $raw):Collection
	{
       return new VenueCollection($raw,$this);
	}

	protected function DoCreateObject(array $raw):DomainObject
	{
		$obj=new venue((int)$raw['id'],$raw['name']);
		return $obj;
	}

	protected function doInsert(DomainObject $object)
	{
     $values=[$object->getName()];
     $this->insertStmt->execute($values);
     $id=$this->pdo->lastInsertId();
     $object->setID((int)$id);
	}

	public function update(DomainObject $object)
	{
      $values=[$object->getName(),$object->getid(),$object->getid()];
      $this->updateStmt->execute($values);
	}

	public function selectsmt()
    {
     return $this->selectsmt;
    }
}



abstract class Collection implements Iterator 
{
protected $mapper;
protected $total=0;
protected $raw=[];

private $pointer=0;
private $objects=[];


public function __contruct(array $raw=[],Mapper $mapper = null)
   {
    $this->raw=$raw;
    $this->total=count($raw);
   
   if(count($raw)&&is_null($mapper))
   {
   	throw new Exception("need objects of class Mapper");
   }
   $this->mapper=$mapper;
   }


public function add(DomainObject $object)
    {
    $class=$this->targetClass();

    if(!($object instanceof $class))
    {
    	throw new Exception(This file in collection);
    }
     
     $this->notifyAcess();
     $this->objects[$this->total]=$objects;
     $this->total++;
    }
abstract public function tergetclass():string;

protected function notifyAcess()
{

}

private function getRow($num)
{
	$this->notifyAcess();

	if($num>=$this->total||$num<0)
	{
		return null;
	}

	if(isset($this->objects[$num]))
	{
     return $this->objects[$num];
	}

	if(isset($this->raw[$num]))
	{
     $this->objects($num)=$this->mapper->createObject($this->raw[$num]);
     return $this->objects($num);
	}
}

public function rewind()
{
	$this->pointer=0;
}

public function current()
{
	return $this->getRow($this->pointer());
}

public function key()
{
	return $this->pointer;
}

public function next()
{
 $row=$this->getrow($this->pointer);
 if(! is_null($row))
 {
 	$this->pointer++;
 }
}

public function valid()
{
	return(! is_null($this->current()));
}


}

class VenueCollection extends Collection
{
	public function targetClass():string
	{
		return Venue::class;
	}
}



$mapper=new VenueMapper();
$vanue=$mapper->find(2);
pront_r($venue);
?>