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
    	

    	public function down(Ghosthes $duration)
    	{
    	 return ("derek");	
    	}
    }
    $lessons=new Double(new Ghosthes(),"здесь водятся призраки");
    
    echo $lessons->down($lessons);
    echo "<br/>";
    echo $lessons->wow($lessons);
?>