<?php

namespace Kalibora\Memoization;

use PHPUnit\Framework\TestCase;

class MemoizationTraitTest extends TestCase
{
    public function testSameInstance(): void
    {
        $memoizationAware = new class() {
            use MemoizationTrait;

            public function getInstance(): Memoization
            {
                return $this->getMemoization();
            }
        };

        $this->assertSame($memoizationAware->getInstance(), $memoizationAware->getInstance());
    }
}
