<?php

namespace AnyJsonTester\Types;

/**
 * Interface AbstractType
 * @package AnyJsonTester\Types
 */
interface AbstractType
{
    /**
     * @param $value
     * @return mixed
     */
    public function check($value);
}