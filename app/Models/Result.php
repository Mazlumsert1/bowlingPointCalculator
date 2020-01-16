<?php

namespace App\Models;

/**
 * Class Result
 * @package App\Models
 */
class Result
{
    /**
     * @var string
     */
    private $token;

    /**
     * @var Frame[]
     */
    private $frames;

    /**
     * @var bool
     */
    private $success = false;

    /**
     * @return string
     */
    public function getToken(): string
    {
        return $this->token;
    }

    /**
     * @param string $token
     * @return Result
     */
    public function setToken(string $token): Result
    {
        $this->token = $token;
        return $this;
    }

    /**
     * @return Frame[]
     */
    public function getFrames(): array
    {
        return $this->frames;
    }

    /**
     * @param Frame[] $frames
     * @return Result
     */
    public function setFrames(array $frames): Result
    {
        $this->frames = $frames;
        return $this;
    }

    /**
     * @return bool
     */
    public function isSuccess(): bool
    {
        return $this->success;
    }

    /**
     * @param bool $success
     * @return Result
     */
    public function setSuccess(bool $success): Result
    {
        $this->success = $success;
        return $this;
    }

    /**
     * @param Frame $frame
     * @return Result
     */
    public function addFrame(Frame $frame): Result
    {
        $this->frames[] = $frame;
        return $this;
    }

    public function deleteFrame(int $index): Result
    {
        unset($this->frames[$index]);
        return $this;
    }

    /**
     * @param int $index
     * @return Frame|null
     */
    public function getFrame(int $index): ?Frame
    {
        return $this->frames[$index] ?? null;
    }
}
