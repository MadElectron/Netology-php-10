<?php

/* ==== Vehicle and Car ==== */

interface Colorable
{
    public function getColor();    
}

interface Paintable
{
    public function paint($r, $g, $b);
}

class CityVehicle
{
    const WHEEL_COUNT = 4;
    
    protected $speed = 0;

    protected static $maxSpeed;
 
    /*
    * Linear increase Vehicle's speed depending on pressing throttle time
    */
    public function throttle($time)
    {
        if ($this->speed < self::$maxSpeed) {
            $this->speed += $time;
        }   
    }

    /*
    * Linear decrease Vehicle's speed depending on pressing break time
    */
    public function break($time) 
    {
        if ($this->speed) {
            $this->speed = 3*$time; //We break faster than throttle
        }
    }

    public static function setMaxSpeed($speed) 
    {
        self::$maxSpeed = $speed;
    }
}

class Car extends CityVehicle implements Paintable, Colorable
{           
    private $wheelCount = parent::WHEEL_COUNT;
    private $color = [255, 255, 255];

    public function __construct($color) 
    {   
        $this->color = $color;
    }

    public function getWheelCount()
    {   
        return $this->wheelCount;
    }

    public function getColor()
    {   
        return $this->color;
    }

    public function getSpeed()
    {   
        return $this->speed;
    }

    public function getMaxSpeed()
    {   
        return self::$maxSpeed;
    }


    public function paint($r, $g, $b)
    {
        if (in_array($r, range(0,255)) or 
            in_array($g, range(0,255)) or
            in_array($b, range(0,255))) {
            echo 'Все компоненты цвета должны быть в диапазоне от 0 до 255'.PHP_EOL;
        }
        else {
            $this->color = [$r, $g, $b];
        }
    }

    public function takeOffWheels($wheelCount)
    {
        if (!$this->wheelCount) {
            echo 'На машине не установлены колёса'.PHP_EOL;
        }
        elseif ($wheelCount > parent::WHEEL_COUNT) {
            echo 'У машины не бывает столько колёс'.PHP_EOL;
        }
        elseif ($wheelCount > $this->wheelCount) {
            echo 'Вы пытаетесь снять колёс больше, чем установлено на машине. Установлено: '.$this->wheelCount.PHP_EOL;
        }
        else {
            $this->wheelCount -= $wheelCount;
        }
    }

    public function takeOnWheels($wheelCount)
    {
        if ($this->wheelCount == parent::WHEEL_COUNT) {
            echo 'На машине установлены все колёса'.PHP_EOL;                
        }
        elseif ($wheelCount + $this->wheelCount > parent::WHEEL_COUNT) {
            echo 'Вы пытаетесь установить колёс больше, чем может быть в машине. Установлено: '.$this->wheelCount.PHP_EOL;
        }
        else {
            $this->wheelCount += $wheelCount;
        }
    }    
}

/* ==== Gadget and TvSet ==== */

interface Powerable
{
    public function clickPower();
} 

class Gadget implements Powerable
{
    protected $serialNumber;
    protected $powerOn = false;

    public function __construct($number)
    {
        $this->serialNumber = $number;
    }

    public function getSerialNumber()
    {
        return $this->serialNumber;
    }

    public function getPowerOn()
    {
        return $this->powerOn;
    }

    public function clickPower() 
    {
        $this->powerOn = !$this->powerOn;
    }
}

class TvSet extends Gadget
{   
    private $channels = ['Первый', 'Россия'];
    private $volume = 0;
    private $currentChannel = 0;

    public function __construct($number)
    {
        parent::__construct($number);
    }

    public function getChannels()
    {
        return $this->channels;
    }

    public function getVolume()
    {
        return $this->powerOn ? $this->volume : 0;
    }

    public function getCurrentChannel()
    {
        return $this->powerOn ? $this->currentChannel : null;
    }

    public function clickTune($channels)
    {
        if ($this->powerOn) {
            $this->channels = array_merge($this->channels, $channels);
        }
    }

    public function clickVolumePlus($time)
    {
        if ($this->powerOn) {
            $newVolume = $this->volume + $time;
            $this->volume = ($newVolume < 100) ? $newVolume : 100;
        }
    }

    public function clickVolumeMinus($time)
    {
        if ($this->powerOn) {
            $newVolume = $this->volume - $time;
            $this->volume = ($newVolume > 0) ? $newVolume : 0;
        }
    }

    public function clickChannelPlus()
    {
        if ($this->powerOn) {
            if ($this->currentChannel == count($this->channels) - 1) {
                $this->currentChannel = 0;
            }
            else {
                $this->currentChannel += 1;    
            }
        }
    }

    public function clickChannelMinus()
    {
        if ($this->powerOn) {
            if ($this->currentChannel == 0) {
                $this->currentChannel = count($this->channels) - 1;
            }
            else {
                $this->currentChannel -= 1;    
            }
        }
    }
}

/* ==== WritingItem and Pen==== */

class WritingItem implements Colorable
{
    protected $color;

    public function __construct($color)
    {
        $this->color = $color;
    }

    public function getColor()
    {
        return $this->color;
    }
}

class Pen extends WritingItem
{
    const PT_INK_RATE = 0.01; //per cent of ink level, spent on 1 char pt

    private $inkLevel = 100;

    public function __construct($color = [0, 0, 255])
    {
        parent::__construct($color);
    }

    public function getInkLevel()
    {
        return $this->inkLevel;
    }

    /*
     * Decreasing ink level depending on written chars and font size (in pt)
    */
    public function write($chars, $fontSize)
    {
        if ($this->inkLevel > 0) {
            $inkRate = self::PT_INK_RATE * $chars * $fontSize;

            if ($this->inkLevel > $inkRate) {
                $this->inkLevel = round($this->inkLeve - $inkRate, 2); // converting floating point to fixed point
            }
            else {
                $possibleChars = floor($this->inkLevel / self::PT_INK_RATE * $fontSize );

                echo "Невозможно написать $chars символов $fontSize-м шифтом оставшимся количеством чернил. Написано $possibleChars символов".PHP_EOL;
            }
        }
    }

    public function recharge()
    {
        $this->inkLevel = 100;
    }
}

//==== Toy and Duck ====

interface Pressable 
{
    public function press();
}

class Toy implements Pressable
{
    protected $color;
    protected $weight;

    public function __construct($color, $weight)
    {
        $this->color = $color;
        $this->weight = $weight;
    }

    public function getColor()
    {
        return $this->color;
    }

    public function getWeight()
    {
        return $this->weight;
    }

    public function press()
    {
        echo "Making sound!".PHP_EOL;
    }
} 

class Duck extends Toy implements Pressable
{

    public function __construct($color = [255, 255, 0], $weight = 100) // Standard yellow rubber duck
    {
        parent::__construct($color, $weight);
    }

    public function press()
    {
        echo "Quack!".PHP_EOL;
    }
}

/* ===== Item and Product ==== */

interface Discountable
{
    public function getDiscount();
    public function setDiscount($discount);
}

class Item
{
    protected $name;
    protected $description;
    protected $category;

    public function __construct($name, $description, $category)
    {
        $this->name = $name;
        $this->description = $description;
        $this->category = $category;
    }    
}

class Product extends Item implements Discountable
{
    private $weight = 100; // Standard weight
    private $price = 0;    // Standard price
    private $discount = 0; // Standard discount

    public function __construct(
        $name, 
        $weight, 
        $price, 
        $description = "", 
        $category = "Uncategorized", 
        $discount = 0)
    {
        parent::__construct($name, $description, $category);

        $this->setWeight($weight);
        $this->setPrice($price);
        $this->setDiscount($discount);
    }

    public function getName()
    {
        return $this->name;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function getCategory()
    {
        return $this->category;
    }

    public function getWeight()
    {
        return $this->weight;
    }

    public function getPrice()
    {
        $price = round($this->price * (1 - 0.01 * ($this->discount)), 2);

        return $price;
    }

    public function getDiscount()
    {
        return $this->discount;
    }

    public function setDescription($description) {
        $this->description = $description;
    }

    public function setCategory($category) {
        $this->category = $category;
    }

    public function setPrice($price) {
        if ($price > 0) {
            $this->price = $price;
        }
        else {
            echo 'Цена не может быть отрицательной. Задана цена по умолчанию: '.$this->price.PHP_EOL;
        }
    }

    public function setDiscount($discount)
    {
        if ($discount >= 0 and $discount < 100) {
            $this->discount = $discount;
        }
        else {
            echo 'Скидка может быть в пределах от 0 до 100 (не включительно). Задана скидка по умолчанию: '.$this->discount.PHP_EOL;
        }
    }

    public function setWeight($weight)
    {
        if ($weight > 0) {
            $this->weight = $weight;
        }
        else {
            echo 'Вес не может быть отрицательным. Задан вес по умолчанию: '.$this->weight.PHP_EOL;
        }
    }
}


/* ==== Main code ==== */

$silverCar = new Car([192, 192, 192]);
$scarletCar = new Car([255, 36, 0]);

$silverCar->setMaxSpeed(300);
echo $silverCar->getMaxSpeed(300).PHP_EOL;

$tvSet1 = new TvSet('TV00001');
$tvSet2 = new TvSet('TV00002');

$tvSet1->clickPower();
$tvSet1->clickVolumePlus(3);
$tvSet1->clickVolumeMinus(2);
echo $tvSet1->getVolume().PHP_EOL;

$bluePen = new Pen();
$greenPen = new Pen([0, 255, 0]);

print_r($bluePen->getColor());

$standardYellowDuck = new Duck();
$hugeCyanDuck = new Duck([0, 255, 255], 3000);

echo $hugeCyanDuck->getWeight().PHP_EOL;
$hugeCyanDuck->press();

$iPhone = new Product('iPhone X', 174, 74999, 'The smartphone of future.', 'Smartphones', 0);
$ps4Pro = new Product('Playstation 4 Pro', 3300, 29999, 'Greatness awaits.', 'Videogame consoles', 10);


$iPhone->setDiscount(25);
echo $iPhone->getPrice();