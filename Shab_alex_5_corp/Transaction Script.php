<?php
abstract class Base
{
	private $dbo;
	private config=__DIR__."/data/woo_options.ini";
	private $stmts=[];
	public function __construct()
	{
		$reg=Registry::instance();
		$options=parse_ini_file($this->config,true);
		$conf=new Conf($options['config']);
		$reg->setConf($conf);
		$dsn=$reg->getDSN();
		if(is_null($dsn))
		{
			throw new Exception("wow");
		}
		$this->pdo=new \PDO($dsn);
		$this->pdo->setAttribute(pdo::atr_errmode,pdo::atr_errmode);
	}
	public function getPDO():PDO
	{
		return $this->pdo;
	}
}

class VenueManager extends Base
{
	private $addVenue="insert into()";
	private $addspace="insert into()";
	private $addevent="insert into()";

	public function addVenue(string $name,array $spaces):array
	{
     $pdo=$this->getpdo();
     $ret=[];
     $ret['venue']=[$name];
     $stmt=$pdo->prepare($this->addvenue);
     $stmt->execute($ret['venue']);
     $vid=$pdo->lastInsertId();

     $ret['spaces']=[];

     $stms=$pdo->prepare($this->addspace);
     foreach ($spaces as $spaceman) 
     {
      $values=[$spaceman,$vid];
      $stmt->execute($values);
      $sid=$pdo->lastInsertId();
      array_unshift($values,$sid);
      $ret['spaces'][]=$values;
     }
     return $ret;
	}

	public function bookevent(int $spaceid,string $name,int $time,int $duration)
	{
    $pdo=$this->getPdo();
    $stmt=$pdo->prepare($this->addevent);
    $stmt->execute([$name,$spaceid,$time,$duration]);
	}
}
?>