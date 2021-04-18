<?php
    Class Ghosthes
    {

     function wow($duration)
     {
      return  "Model";
     }
    }


    Class Double extends Ghosthes
    {
    	//можно убрать - не фатально
        function __construct(Ghosthes $duration,$name)
        {
        	echo ($name." "."derek");
        }

    	public function down(Ghosthes $duration)
    	{
    	 return ("derek");	
    	}
    }
    $lessons=new Double(new Ghosthes(),"здесь водятся призраки");
    //или можно вот это , если убрать конструктор сверху
    //echo $lessons->down($lessons);
    echo "<br/>";
    echo $lessons->wow($lessons);
?>