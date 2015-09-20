<?php

namespace AnyJsonTester\Types;

interface AbstractType
{
    public function check($value);
}