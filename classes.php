<?php

class Car
{           
    const WHEEL_COUNT = 4;

    private $wheelCount = self::WHEEL_COUNT;
    private $color = [255, 255, 255];
    private $speed = 0;

    private static $maxSpeed;

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
        elseif ($wheelCount > self::WHEEL_COUNT) {
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
        if ($this->wheelCount == self::WHEEL_COUNT) {
            echo 'На машине установлены все колёса'.PHP_EOL;                
        }
        elseif ($wheelCount + $this->wheelCount > self::WHEEL_COUNT) {
            echo 'Вы пытаетесь установить колёс больше, чем может быть в машине. Установлено: '.$this->wheelCount.PHP_EOL;
        }
        else {
            $this->wheelCount += $wheelCount;
        }
    }    

    /*
    * Linear increase Car's speed depending on pressing throttle time
    */
    public function throttle($time)
    {
        if ($this->speed < self::$maxSpeed) {
            $this->speed += $time;
        }   
    }

    /*
    * Linear decrease Car's speed depending on pressing break time
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


class TvSet
{   
    private $serialNumber;
    private $channels = ['Первый', 'Россия'];
    private $powerOn = false;
    private $volume = 0;
    private $currentChannel = 0;

    public function __construct($number)
    {
        $this->serialNumber = $number;
    }

    public function getChannels()
    {
        return $this->channels;
    }

    public function getPowerOn()
    {
        return $this->powerOn;
    }

    public function getVolume()
    {
        return $this->powerOn ? $this->volume : 0;
    }

    public function getCurrentChannel()
    {
        return $this->powerOn ? $this->currentChannel : null;
    }


    public function clickPower() 
    {
        $this->powerOn = !$this->powerOn;
    }

    public function clickTune($channels)
    {
        if ($this->$powerOn) {
            $this->channels = array_merge($this->channels, $channels);
        }
    }

    public function clickVolumePlus($time)
    {
        if ($this->$powerOn) {
            $newVolume = $this->volume + $time;
            $this->volume = ($newVolume < 100) ? $newVolume : 100;
        }
    }

    public function clickVolumeMinus($time)
    {
        if ($this->$powerOn) {
            $newVolume = $this->volume - $time;
            $this->volume = ($newVolume > 0) ? $newVolume : 0;
        }
    }

    public function clickChannelPlus()
    {
        if ($this->$powerOn) {
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
        if ($this->$powerOn) {
            if ($this->currentChannel == 0) {
                $this->currentChannel = count($this->channels) - 1;
            }
            else {
                $this->currentChannel -= 1;    
            }
        }
    }
}


class Pen 
{
    const PT_INK_RATE = 0.01; //per cent of ink level, spent on 1 char pt

    private $color;
    private $inkLevel = 100;

    public function __construct($color = [0, 0, 255])
    {
        $this->color = $color;
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

class Duck 
{
    private $color;
    private $weight;

    public function __construct($color = [255, 255, 0], $weight = 100) // Standard yellow rubber duck
    {
        $this->color = $color;
        $this->weight = $weight;
    }

    public function getColor()
    {
        return $this->color;
    }

    public function getWeigth()
    {
        return $this->weight;
    }

    public function press()
    {
        echo "Quack!".PHP_EOL;
    }
}

class Product
{
    private $name;
    private $description;
    private $category;
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
        $this->name = $name;
        $this->description = $description;
        $this->category = $category;

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
        $price = $round($this->price * (1 - 0.01 * ($this->discount)), 2);

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

$tvSet1 = new TvSet('TV00001');
$tvSet2 = new TvSet('TV00002');

$bluePen = new Pen();
$greenPen = new Pen([0, 255, 0]);

$standardYellowDuck = new Duck();
$hugeCyanDuck = new Duck([0, 255, 255], 3000);

$iPhone = new Product('iPhone X', 174, 74999, 'The smartphone of future.', 'Smartphones', 0);
$ps4Pro = new Product('Playstation 4 Pro', 3300, 29999, 'Greatness awaits.', 'Videogame consoles', 10);
