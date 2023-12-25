<?php

class  orders{
private $order_id ;
private $creation_date;
private $shipping_date;
private $delivery_date;
private $total_price;
private $bl;

public function __construct($order_id , $creation_date , $shipping_date , $delivery_date , $total_price , $bl){
    $this-> order_id = $order_id ;
    $this-> creation_date = $creation_date;
    $this-> shipping_date = $shipping_date ;
    $this-> delivery_date = $delivery_date ;
    $this-> total_price = $total_price ;
    $this-> bl = $bl ;
}
public function getOrderId()
{
    return $this ->order_id;
}
public function getCreationDate(){
    return $this ->creation_date;
}
public function getShippingDate(){
    return $this ->shipping_date;
}
public function getDeliveryDate(){
    return $this ->delivery_date;
}
public function getTotalPrice(){
    return $this ->total_price;
}
public function getBl(){
    return $this ->bl;
}
}
?>

