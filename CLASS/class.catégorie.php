<?php
class Categories {
private $catname;
private $descrip;
private $imgs;
private $bl;

public function getCatname (){
    return $this->catname;
}
public function getDescrip (){  
    return $this->descrip;
}
public function getimgs (){
    return $this->imgs;
}
public function getBl (){
    return $this->bl;
}




}


?>
    catname VARCHAR(50) PRIMARY KEY,
    descrip TEXT,
    imgs VARCHAR(250),
    bl BOOLEAN 
    private $imgs;1

    public function getReference()
    {
        return $this ->reference;
    }2