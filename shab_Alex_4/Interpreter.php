<?php

abstract class Expression
{
	private static $keycount=0;
	private $key;

	abstract public function interpret(InterpreterContext $context);

	public function getKey()
	{
		if(!isset($this->key))
		{
			self::$keycount++;
			$this->key=self::$keycount;
		}
		return $this->key;
	} 
}

class LiteralExpression extends Expression
{
	private $value;

	public function __construct($value)
	{
		$this->value=$value;
	}

	public function interpret(InterpreterContext $context)
	{
		$context->replace($this,$this->value);
	}
}

class InterpreterContext
{
	private $expressionstore=[];
	public function replace(Expression $exp,$value)
	{
		$this->expressionstore[$exp->getkey()]=$value;
	}

	public function lookup(Expression $exp)
	{
		return $this->expressionstore[$exp->getKey()];
	}
}

class VariableExpression extends Expression
{
private $name;
private $val;

  public function __construct($name,$val=null)
  {
  $this->name=$name;
  $this->val=$val;
  }

  public function interpret(InterpreterContext $context)
  {
  if(!is_null($this->val))
   {
   $context->replace($this,$this->val);
   $this->val=null;
   }
  }

  public function setValue($value)
  {
   $this->val=$value;
  }

  public function getKey()
  {
  	return $this->name;
  }
}

abstract class OperatorExpression extends Expression
{
	protected $l_op;
	protected $r_op;
    public function __construct(Expression $l_op,Expression $r_op)
    {
     $this->l_op=$l_op;
     $this->r_op=$r_op;
    }


    public function interpret(InterpreterContext $context)
    {
    	$this->l_op->interpret($context);
    	$this->r_op->interpret($context);
    	$result_l=$context->lookup($this->l_op);
    	$result_r=$context->lookup($this->r_op);
    	$this->dointerpret($context,$result_l,$result_r);
    }


    abstract protected function dointerpret(InterpreterContext $context,$result_l,$result_r);
}


class Equals extends OperatorExpression
{
	protected function dointerpret(InterpreterContext $context,$result_l,$result_r)
	{
		$context->replace($this,$result_l==$result_r);
	}
}

class BooleanAndExpression extends OperatorExpression
{
	protected function dointerpret(InterpreterContext $context,$result_l,$result_r)
	{
      $context->replace($this,$result_l&&$result_r);
	}
}


class BooleanOrExpression extends OperatorExpression
{
	protected function dointerpret(InterpreterContext $context,$result_l,$result_r)
	{
      $context->replace($this,$result_l||$result_r);
	}
}

$context=new InterpreterContext();
$input=new VariableExpression('input');
$statement=new BooleanOrExpression(new Equals($input,new LiteralExpression('cheture')),new Equals($input,new LiteralExpression('4')));

foreach(["четыре","4","52"]as $val)
{
	$input->setValue($val);
	print $val;
	$statement->interpret($context);
	if($context->lookup($statement))
	{
		print "все правильно!"."<br/>";
	}
	else
	{
		print "вы ошиблись";
	}
}


?>