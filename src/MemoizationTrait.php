<?php

namespace Kalibora\Memoization;

trait MemoizationTrait
{
    private ?Memoization $memoization = null;

    private function getMemoization(): Memoization
    {
        if ($this->memoization === null) {
            $this->memoization = new Memoization();
        }

        return $this->memoization;
    }
}
