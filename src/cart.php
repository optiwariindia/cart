<?php
namespace optiwariindia;

class cart
{
    private $cart = [],$param=[];
    public function __Construct()
    {
        // checking if session is started
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        if (isset($_SESSION['cart'])) {
            $this->cart = $_SESSION['cart'];
        }
    }
    public function setParams($param=[]){
        $this->param=$param;
    }
    public function add($item)
    {
        $update=true;
        foreach ($this->cart as $key => $value) {
            $match=true;
            foreach ($this->param as $param) {
                if($match && ($value[$param]==$item[$param])){
                    $match=true;
                }else{
                    $match=false;
                }
            }
            if($match && $update){
                $value['count']+=$item['count'];
                $update=false;
                $this->cart[$key]=$value;
            }
        }
        if($update){
            $this->cart[]=$item;
        }
        $this->update();
    }
    public function remove($item)
    {
        foreach ($this->cart as $key => $value) {
            $match=true;
            foreach ($this->param as $param) {
                if($match && ($value[$param]==$item[$param])){
                    $match=true;
                }else{
                    $match=false;
                }
            }
            if($match){
                unset($this->cart[$key]);
            }
        }
        $this->update();
    }
    public function update()
    {
        $_SESSION['cart']=$this->cart;
    }
    public function count()
    {
        return array_reduce(
            $this->cart,
            function ($a,$b){
                return $a+$b['count'];
            },
            0);
    }
    public function get()
    {
        return $this->cart;
    }
}
