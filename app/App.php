<?php

namespace App;

use App\Models\Frame;
use App\Services\Bowling\Calculator;
use Exception;

/**
 * Class App
 * @package App
 */
class App
{
    /**
     * @var Calculator
     */
    private $calculator;

    public function __construct(Calculator $calculator)
    {
        $this->calculator = $calculator;
    }

    /**
     * Start the calculator.
     * @throws Exception
     */
    public function start()
    {
        $result = $this->calculator->getResult();
        $frameRools = array_map(function (Frame $frame) {
            $type = 'default';
            if ($frame->isStrike()) {
                $type = 'strike';
            } elseif ($frame->isSpare()) {
                $type = 'spare';
            }

            return sprintf('[First:%s, Second:%s, Result:%s, Type:%s]', $frame->getFirstRoll(), $frame->getSecondRoll(),
                $frame->getResult(), $type);
        }, $result->getFrames());

        echo "=============================================\n";
        echo "= Bowling Point Calculator\n";
        echo "=============================================\n";
        echo "Frames:\n";
        foreach ($frameRools as $frameRool) {
            echo "{$frameRool}\n";
        }
        echo "---------------------------------------------\n";
        echo "Results: ";
        echo $result->isSuccess() ? 'OK' : 'WRONG!';
        echo "\n";
    }
}
