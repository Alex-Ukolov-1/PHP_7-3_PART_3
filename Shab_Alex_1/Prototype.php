<?php
   class Sea
   {

   }

   class EathSea extends Sea
   {

   }

   class MarsSea extends Sea
   {

   }

   class Plains
   {

   }

   class EathPlains extends Plains
   {

   }

   class MarsPlains extends Plains
   {

   }

   class Forest
   {

   }

   class EathForest extends Forest
   {

   }

   class MarsForest extends Forest
   {

   }

   class TerrainFactory
   {
   	private $sea;
   	private $forest;
   	private $plains;
   	public function __construct(Sea $sea,Plains $plains,Forest $forest)
   	{
     $this->sea=$sea;
     $this->plains=$plains;
     $this->forest=$forest;
   	}

   	public function getSea():Sea
   	{
    return clone $this->sea;
   	}
    
    public function getPlains():Plains
   	{
    return clone $this->plains; 
   	}

   	public function getForest():Forest
   	{
   		return clone $this->forest;
   	}
   }
    $factory=new TerrainFactory(new Sea(),new Plains(),new Forest());

    print_r($factory->getSea());
    print_r($factory->getPlains());
    print_r($factory->getForest());

?>