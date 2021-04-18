<?php
class ObjectWatcher
{
	private $all=[];
	private $dirty=[];
	private $new=[];
	private $delete=[];
	private static $instance=null;

	public static function AddDelete(Domainobject $obj)
	{
		$inst=self::inctsnce();
		$inst->delete[$self->globalKey($obj)]=$obj;
	}

	public static function addDirty(Domainobject $obj)
	{
     $inst=self::instance();

     if(! in_array($obj,$inst->new,true))
     {
     	$inst->dirty[$inst->globalKey($obj)]=$obj;
     }
	}

	public static function addNew(Domainobject $obj)
	{
		$inst=self::instance();

		$inst->new[]=$obj;
	}

	public static function addClean(Domainobject $obj)
	{
     $inst=self::instance();
     unset($inst->delete($inst->globalKey($obj)));
     unset($inst->dirty($inst->globalKey($obj)));

     $inst->new=array_filter($inst->new,function($a) use ($obj)
     {
     	return !($a===$obj);
     }
    );
    }

    public function performOperations()
    {
     foreach ($this->dirty as $key=>$obj) 
     {
     $obj->getFinder()->update($obj);
     }
     foreach ($this->new as $key => $obj) 
     {
       $obj->getFinder()->insert($obj);
       print "".$obj->getname();
     }
     $this->dirty=[];
     $this->new=[];
    }
}


abstract class Domainobject
{
	private $id;

	public function __construct(int $id)
	{
		$this->id=$id;

		if($id<0)
		{
			$this->markNew();
		}
	}

	abstract public function getFinder():Mapper
	{
		public function getid():int
		{
			return $this->id;
		}

		public function setid(int $id)
		{
			$this->id=$id;
		}

		public function markNew()
		{
			ObjectWatcher::addNew($this);
		}

		public function markDeleted()
		{
			ObjectWatcher::AddDelete($this);
		}

		public function markDirty()
		{
			ObjectWatcher::addDirty($this);
		}

		public function markClean()
		{
			ObjectWatcher::addClean($this);
		}
	} 
}


class Mapper
{
   public function createObject($raw):Domainobject
   {
   	$old=$this->getFromMap($raw['id']);
   	if(! is_null($old))
   	{
     return $old;
   	}
   	$obj=$this->docreateobject($raw);
   	$this->addtoMap($obj);

   	return $obj;
   }
}

class Space
{
     public function setVenue(Venue $venue)
     {
      $this->venue=$venue;
      $this->markDirty();
     }

     public function setName(string $name)
     {
      $this->name=$name;
      $this->markDirty();
     }
}

?>