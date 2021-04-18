<?php
require_once('Franz.php');
//функция с уточнённым типом класса внутри метода
//метод внутри которого метод
class ISPANIA extends Franz
{
    function __construct($ispania)
    {
    	$this->ispania=$ispania;
    }

    public function fergus(ISPANIA $ispania)
    {
     $this->ispania=Franz::feel($ispania);
     $this->$dead->render();
    }
}
$writer=new ISPANIA("Catalonia");
$writer->fergus(new ISPANIA("Catalonia"));
?>