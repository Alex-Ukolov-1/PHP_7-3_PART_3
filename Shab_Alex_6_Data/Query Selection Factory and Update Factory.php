<?php
abstract class UpdateFactory
{
	abstract public function newupdate(DomainObject $obj):array;


	protected function buildStatement(string $table,array $fields,array $conditions=null):array
	{
		$terms=array();

		if(! is_null($conditions))
		{
			$query="UPDATE [$table] SET";
			$query.=implode("=?,",array_keys($fields));
			$terms=array_values($fields);
			$cond=[];
			$query.=" WHERE ";
			foreach ($conditions as $key => $val) 
			{
             $cond[]="$key=?";
             $terms[]=$val;
            }

            $query.=implode("AND",$cond);
		}
		else
		{
			$query="INSERT INTO [$table] (";
			$query=implode(",",array_keys($fields));
			$query.=")VALUES("

			foreach ($fields as $name => $value) 
			{
				$terms[]=$value;
				$qs[]='?';
			};
			$query.=implode(",",$qs);
			$query.=")";
		}
		return array($query,$terms);
	}
}

class VenueUpdate extends UpdateFactory
{
	public function newupdate(DomainObject $obj):array
	{
		$id=$obj->getId();
		$cond=null;
		$values['name']=$obj->getname();

		if($id>-1)
		{
			$cond['id']=$id;
		}
		return $this->buildStatement("venue",$values,$cond);
	}
}

abstract class SelectionFactory
{
	abstract public function newSelection(Identity $obj):array;

	public function buildWhere(IdentityObject $obj):array
	{
		if($obj->isvoid())
		{
			return ["",[]];
		}

		$compstrings=[];
		$values=[];

		foreach ($obj->getComps() as $comp) 
		{
		 $compstrings[]="{$comp['name']}{$comp['operator']}?";
		 $values[]=$comp['value'];
		}

		$where="WHERE".implode("AND",$compstrings);

		return[$where,$values];
	}
}

class VenueSelectionFactory extends SelectionFactory
{
	public function newSelection(IdentityObject $obj):array
	{
		$fields=implode(',',$obj->getobject());
		$core="SELECT $fields From venue";
		list($where,$values)=$this->buildWhere($obj);

		return [$core." ".$where,$values];
	}
}

?>