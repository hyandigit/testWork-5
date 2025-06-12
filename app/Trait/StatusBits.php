<?php

namespace App\Trait;

trait StatusBits
{
    public function getBit($number)
    {
        return ($this->status >> $number) & 0x1;
    }

    public function setBit($number, $value)
    {
        $val = $this->getBit($number);
        (($val && !$value) || (!$val && $value)) && $this->status ^= (0x1 << $number);
    }
}
