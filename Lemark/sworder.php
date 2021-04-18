<?php

function reload($web)
{
	try
   {  if($web!="")
	   {
echo "<a href='$web'>";
echo "<img src='$web' alt='' width='100'/>";
echo "</a>";
	   }
	   else
	    {throw new Exception();}
   }
	catch(\Throwable $e)
    {
	echo('произошла ошибка');
    }
  
}

class red
{
public static function zoo($name)
{
 echo $reload=$name;
}
}


 
?>