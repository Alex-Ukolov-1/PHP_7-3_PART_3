<?php
//
//
Class Franz
{
	public static function feel($ispania)
	{
	var_dump($ispania);
	echo "<br/>";
    }

    public function render()
    {
        return var_dump(function($item){return $item->render();},$this->$ispania);
    }
}

?>