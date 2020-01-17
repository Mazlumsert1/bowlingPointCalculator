<?php

use App\Models\Frame;
use App\Models\Result;
use PHPUnit\Framework\TestCase;

/**
 * Class Test
 * @package tests\unit
 */
class Test extends TestCase
{

    /**
     * @var Frame
     */
    private $frame;
    /**
     * @var Result
     */
    private $result;

    public function setUp()
    {
        $this->result = new Result();
        $this->frame = new  Frame(0, 0);

    }

    public function testIsStrike()
    {

        $this->assertIsBool(false, $this->frame->isStrike());
    }

    public function testIsSpare()
    {

        $this->assertIsBool(false, $this->frame->isSpare());
    }

    public function testsetFramesToResult()
    {

        $frameOne = new Frame(0, 0);

        $frameTwo = new Frame(0, 0);

        $this->result->setFrames([$frameOne, $frameTwo]);

        $this->assertSame(2, count($this->result->getFrames()));
    }


    public function testAddFrameToResult()
    {
        $this->result->addFrame(new Frame(0, 0));

        $this->assertSame(1, count($this->result->getFrames()));
    }

    public function testDeleteFrameToResult()
    {

        $this->result->addFrame(new Frame(0, 0));

        $this->result->deleteFrame(0);

        $this->assertSame(0, count($this->result->getFrames()));
    }

    public function testCanGetFrameByResult()
    {

        $frameObject = new Frame(0, 0);

        $this->result->addFrame($frameObject);

        $this->assertSame(get_class($frameObject), get_class($this->result->getFrame(0)));

    }

    public function testCanGetNullFromResult()
    {
        $this->assertNull($this->result->getFrame(0));
    }


}
