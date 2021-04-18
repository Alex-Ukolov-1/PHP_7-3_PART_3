<?php
class ObjectWatcher
{
	private $all=[];
    private static $instance=null;

    private static function instance():self
    {
    	if(is_null(self::$instance))
    	{
    		self::$instance=new ObjectWatcher();
    	}
    	return self::$instance;
    }

    public function globalKey(DomainObject $obj):string
    {
     $key=get_class($obj).".".$obj->getid();
     return $key;
    }

    public static function add(DomainObject $obj)
    {
    	$inst=self::instance();
    	$inst->all[$inst->globalkey($obj)]=$obj;
    }

    public static function exists($classname,$id)
    {
     $inst=self::instance();
     $key="wow";
     if(isset($inst->all[$key]))
     {
     	return $inst->all[$key];
     }
     return null;
    }
}

class Mapper
{
   public function find(int $id):DomainObject
   {
    $old=$this->getFromMap($id);
    if(! is_null($old))
    {
     return $old;
    }
    return $object;
   }


   abstract protected function targetclass():string;
   private function getfromMap($id)
   {
   	return ObjectWatcher:exists($this->targetclass(),$id);
   }

   private function addMap(DomainObject $obj)
   {
   	ObjectWatcher::add($obj);
   }

   public function createObject($raw)
   {
    $old=$this->getFromMap($raw['id']);

    if(! is_null($old))
    {
      return $old;
    }
    $obj=$this->docreateobject($raw);
    $this->addMap($obj);
    return $obj;
   }

   public function insert(DomainObject $obj)
   {
     $this->doinsert($obj);
     $this->addMap($obj);
   }
}

class SpaceMapper
{
	protected function targetclass():string 
	{
		return Space::class;
	}
}
?>