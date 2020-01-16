<?php

use PHPUnit\Framework\TestCase;

/**
 * Class Test
 * @package tests\unit
 */
class Test extends TestCase
{

    public function setUp()
    {

    }

    public function testIsStrike()
    {
        $frame = new \App\Models\Frame(0, 0);

        $this->assertIsBool(false, $frame->isStrike());
    }

    public function testIsSpare()
    {
        $frame = new \App\Models\Frame(0, 0);

        $this->assertIsBool(false, $frame->isSpare());
    }


}
