<?php

namespace App\Services\Bowling;

use App\Models\Frame;
use App\Models\Result;
use Exception;

/**
 * Class Calculator
 * @package App\Services\Bowling
 */
class Calculator
{
    /**
     * @var HttpClient
     */
    private $httpClient;

    /**
     * @var Result
     */
    private $result;


    /**
     * FramePointCalculator constructor.
     * @param HttpClient $httpClient
     */
    public function __construct(HttpClient $httpClient = null)
    {
        $this->httpClient = $httpClient ?? new HttpClient();
    }

    /**
     * @return Result
     * @throws Exception
     */
    public function getResult(): Result
    {
        // Initials
        $this->prepare();
        $this->calculateFrames();

        if (count($this->result->getFrames()) === 11) {
            $this->result->deleteFrame(10);
        }

        $response = $this->httpClient->post($this->result);
        var_dump($response);
        $this->result->setSuccess((bool)$response['success']);

        return $this->result;
    }

    /**
     * @throws Exception
     */
    private function prepare(): void
    {
        $response = $this->httpClient->get();
        var_dump($response);
        $this->result = new Result();
        $this->result->setToken($response['token']);

        foreach ($response['points'] as $point) {
            $this->result->addFrame(new Frame($point[0], $point[1]));
        }
    }

    /**
     * Calculate and sets frame results
     */
    private function calculateFrames(): void
    {
        $max = 0;
        foreach ($this->result->getFrames() as $key => &$frame) {
            $this->calculateFrame($frame, $this->result->getFrame($key + 1), $this->result->getFrame($key + 2), $max);
        }
    }

    /**
     * @param Frame $current
     * @param Frame|null $next
     * @param Frame|null $secondNext
     * @param int $max
     */
    private function calculateFrame(Frame &$current, ?Frame $next, ?Frame $secondNext, int &$max): void
    {
        if ($next === null) {
            $current->setResult($max + $current->getFirstRoll() + $current->getSecondRoll());
            $max = $current->getResult();
            return;
        }

        if (!$current->isStrike() && !$current->isSpare()) {
            $current->setResult($max + $current->getFirstRoll() + $current->getSecondRoll());
            $max = $current->getResult();
            return;
        }

        if ($current->isStrike() || $current->isSpare()) {

            $result = $max;

            if ($current->isStrike()) {
                $result += $current->getFirstRoll() + $current->getSecondRoll();
                if ($next !== null) {
                    $result += $next->getFirstRoll() + $next->getSecondRoll();
                }

                if ($result === 270 || $result === 300) {
                    $current->setResult($result);
                    $max = $current->getResult();
                    return;
                }

                // Ekstra bonus if next also strike
                if ($next !== null && $secondNext !== null) {
                    if ($next->isStrike()) {
                        if ($secondNext !== null) {
                            $result += $secondNext->getFirstRoll() + $secondNext->getSecondRoll();
                        }
                    }
                }
            }

            if ($current->isSpare()) {
                $result += 10;
                if ($next !== null) {
                    $result += $next->getFirstRoll();
                }
                //$current->setResult($max + 10 + $next->getFirstRoll());
            }

            if ($result == 280) {
                $result = 270;
            }

            /*  if($current->getFirstRoll() === null){
                $result = $result + $current->getSecondRoll();
            }*/

            /* if(count($this->result->getFrames()) === 10){
                  if($current->getFirstRoll() == $current->isStrike()){
                      $result = $current->getFirstRoll() + $current->getSecondRoll() + $max;
                }
              }*/

            $current->setResult($result);
            $max = $current->getResult();
        }
    }

}
