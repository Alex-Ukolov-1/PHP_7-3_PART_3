<?php

class Dead
{
public $params=[];
   public function Addparam(string $key,$val)
   {
    $this->params[$key]=$val;
   }
}
$alone=new Dead();
$alone->Addparam("clocke",1);
$alone->Addparam("clocke",2);
$alone->Addparam("clocke",3);
$alone->Addparam("clocke",4);
$alone->Addparam("clocke",5);
$alone->Addparam("clocke",6);
$alone->Addparam("clocke",7);
$alone->Addparam("clocke",8);
$alone->Addparam("clocke",9);
$alone->Addparam("clocke",10);
var_dump($alone);

?>