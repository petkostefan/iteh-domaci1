<?php

date_default_timezone_set("Europe/Belgrade");

class Task{
    public $id;
    public $naslov;
    public $opis;
    public $prioritet;
    public $vreme;

    public function __construct($id=null, $naslov=null, $opis=null, $prioritet=null)
    {
        $this->id = $id;
        $this->naslov = $naslov;
        $this->opis = $opis;
        $this->prioritet = $prioritet
        $this->vreme = date("d.m.y. h:m")
    }
    

}

?>