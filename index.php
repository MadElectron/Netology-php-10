<?php

trait calculateDiscount
{
    public function calculateDiscount($baseDiscount)
    {
        return ($this->weight > 10) ? $baseDiscount : 0;
    }
}

class Product
{
    protected $title;
    protected $price;
    protected $discount;
    protected $deliveryPrice;    

    public function __construct($title, $price, $discount)
    {
        $this->title = $title;
        $this->price = $price;
        $this->discount = $discount;
        $this->deliveryPrice = $discount ? 300 : 250;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    public function getPrice()
    {
        return round($this->price*(1 - 0.01 * $this->discount));
    }

    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    public function getDiscount()
    {
        return $this->discount;
    }

    public function setDiscount($discount)
    {
        $this->discount = $discount;

        return $this;
    }

    public function getDeliveryPrice()
    {
        return $this->deliveryPrice;
    }

    public function setDeliveryPrice($deliveryPrice)
    {
        $this->deliveryPrice = $deliveryPrice;

        return $this;
    }

}

class MusicAlbum extends Product
{
    private $duration;
    private $tracks;

    public function __construct($title, $artist, $duration, array $tracks, $price)
    {
        parent::__construct($title, $price, $discount = 10);

        $this->price;
        $this->tracks = $tracks;
    }


    public function getDuration()
    {
        return $this->duration;
    }

    public function setDuration($duration)
    {
        $this->duration = $duration;

        return $this;
    }

    public function getTracks()
    {
        return $this->tracks;
    }

    public function setTracks($tracks)
    {
        $this->tracks = $tracks;

        return $this;
    }


}

class Pencil extends Product
{
    private $color = [127, 127, 127];

    public function __construct($title, $price, array $color) {
        parent::__construct($title, $price, $discount = 10);

        $this->color = $color;
    }

    public function getColor()
    {
        return $this->color;
    }

    public function setColor($color)
    {
        $this->color = $color;

        return $this;
    }
}

class Food extends Product
{
    private $weight;

    use calculateDiscount;

    public function __construct($title, $price, $weight, $discount) {

        $this->weight = $weight;

        $calculatedDiscount = $this->calculateDiscount($discount);

        parent::__construct($title, $price, $calculatedDiscount);
        
    }

    public function getWeight()
    {
        return $this->weight;
    }

    public function setWeight($weight)
    {
        $this->weight = $weight;

        return $this;
    }
}


// ==== Main code ====

$whiskey = new Food('Whiskey', 4000, 2, 10);

echo $whiskey->getPrice().PHP_EOL;
echo $whiskey->getDeliveryPrice().PHP_EOL;

$potatoes = new Food('Potatoes', 450, 15, 20);
echo $potatoes->getPrice().PHP_EOL;

$tracks = ['Cowboys from Hell', 'Primal Concrete Sledge','Domination', 'Cemetery Gates'];
$cowboysFromHell = new MusicAlbum('Cowboys from Hell', 'Pantera', '48:00', $tracks, 500);
echo $cowboysFromHell->getPrice().PHP_EOL;

$yellowPencil = new Pencil('Standard boring yellow pencil', 20, [255, 255, 0]);
echo $yellowPencil->getPrice().PHP_EOL;