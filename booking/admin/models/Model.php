<?php

class Model
{
   public function createPdo()
   {
       return new PDO("mysql:host=localhost;dbname=booking", "root", "");
   }
}
?>
