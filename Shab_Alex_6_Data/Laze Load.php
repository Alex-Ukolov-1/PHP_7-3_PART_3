<?php
class SpaceMapper
{
	protected function doCreate(array $raw):domainObject
	{
		$obj=new Space((int)$raw['id'],$raw['name']);
		$vanmapper=new VenueMapper();
		$venue=$venmapper->find((int)$raw['venue']);
		$obj->setVenue($venue);

		$eventmapper=new eventmapper();
		$eventcollection=$eventmapper->findbyspaceid((int)$raw['id']);
		$obj->setEvents($eventcollection);
		return $obj;
	}
}

class Space
{
	public function getEvent()
	{
		if(is_null($this->events))
		{
			$this->events=$this->getFinder()->findbySpaceId($this->getid());
		}

		return $this->events;
	}
}

class DeferredEventCollection extends eventcollection
{

private $stmt;
private $valueArray;
private $run=false;
 public function __construct(	Mapper $mapper;\PDOstatement $stmt_handle;$this->valueArray=$valueArray;)
    {
    	parent::__construct([],$mapper);
    	$this->stmt=$stmt_handle;
    	$this->valueArray=$valueArray;
    }

    public function notifyAccess()
    {
      if(! $this->run)
      {
      	$this->stmt->execute($this->valueArray);
      	$this->raw=$this->stmt->fetch();
      	$this->total=count($this->raw);
      }
      $this->run=true;
    }
 
}

class EventMapper
{
    public function findbyspaceid(int $id)
    {
    return new DeferredEventCollection($this,$this->selectbyspaceStmt,[$said]);
    }
}

?>