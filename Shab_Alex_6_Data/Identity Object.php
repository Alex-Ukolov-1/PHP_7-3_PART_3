<?php

class IdentityObject
{
	private $name=null;
	public function setName(string $name)
	{
		$this->name=$name;
	}

	public function getName():string
	{
		return $this->name;
	}
}

class EventIdentityObject extends IdentityObject
{
	private $start=null;
	private $minstart=null;

	public function setMinimumStart(int $minstart)
	{
		$this->minstart=$minstart;
	}

	public function getMINIMUMsTART()
	{
		RETURN $THIS->minstart;
	}

	public function setStart(int $start)
	{
       $this->start=$start;
	}

	public function getStart()
	{
		return $this->start;
	}
}

class Field
{
protected $name=null;
protected $operator=null;
protected $comps=[];
protected $incomplete=false;

public function __construct(string $name)
 {
 $this->name=$name;
 }

 public function addtest(string $operator,$value)
 {
  $this->comps[]=['name'=>$this->name,'operator'=>$operator,'value'=$value];
 }

 public function getcomps():array
 {
 	return $this->comps;
 }

 public function isIncomplete():bool
 {
 	return empty($this->comps);
 }

}

class IdentityObject
{
protected $currentfield=null;
protected $fields=[];
private $enforce=[];

 public function __construct(string $field=null,array $enforce=null) 
 {
   if(! is_null($enforce))
   {
   	$this->enforce=$enforce;
   }
   if(! is_null($filed))
   {
   	$this->field($fields);
   }
 }

 public function getObjectFields()
 {
 	return $this->enforce;
 }

 public function field(string $fieldname):self
 {
 	if (! $this->isVoid()&& $this->currentfield->isIncomplete())
 	{
 		throw new exception("problem 1");
 	}

 	$this->enforceField($fieldname);

 	if(isset($this->fields[$fieldname]))
 	{
 	$this->currentfield->$this->fields[$fieldname];
 	}
 	else
 	{
     $this->currentfield=new field($fieldname);
     $this->fields[$fieldname]=$this->currentfield;    
 	}
 	return $this;
 }

 public function enforceField(string $fieldname)
 {
 	if(! in_array($fieldname,$this->enforce)&&! empty($this->enforce))
 	{
 		$forcelist=implode(',',$this->enforce);
 		throw new exception("{$fieldsname} isnot correct!");
 	}
 }

public function eq($value):self
{
	return $this->operator('=',$value);
}

public function It($value):self
{
 return $this->operator("<",$value);
}

public function gt($value):self
{
	return $this->operator(">",$value);
}

private function operator(string $symbol,$value):self
{
	if($this->isVoid())
	{
		throw new exception("the fieldsis not current");
	}
	$this->currentfield->addtest($symbol,$value);

	return $this;
}

public function getComps():array
{
	$ret=[];

	foreach ($this->fields as $field)
	{
		$ret=array_merge($ret,$field->getComps());
	}

	return $ret;
	}
}

}

class EventIdentityObject extends IdentityObject
{
	public function __construct(string $field=null)
	{
     parent::__construct($field,['name','id','start','duration','space']);
	}
}
?>