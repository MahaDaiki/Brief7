<?php
class produit{
    private $reference ;
    private $imgs;
    private $productname;
    private $barcode ;
    private $purchase_price;
    private $final_price ;
    private $price_offer ;
    private $descrip ;
    private $min_quantity;
    private $category_name;
    private $stock_quantity;
    private $bl;
    public function getReference()
    {
        return $this ->reference;
    }
    public function setImgs()
    {
        return $this-> imgs;
    }
    public function setProductname($productname){
        $this -> productname = $productname;
    }
    public function getProductname(){
        return $this -> productname;
    }
    public function setBarcode($barcode){
}


}

?>    