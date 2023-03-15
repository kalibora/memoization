<?php

namespace Kalibora\Memoization;

use PHPUnit\Framework\TestCase;

/**
 * @phpstan-type DependsData = array{0: Memoization, 1: int, 2: callable}
 */
class MemoizationTest extends TestCase
{
    /**
     * @phpstan-return DependsData
     */
    public function testInnerProcessIsCalledOnlyOnceWhenMultipleCalls(): array
    {
        $memo = new Memoization();
        $count = 0;

        $func = function () use ($memo, &$count) {
            return $memo->memoize('foo', function () use (&$count) {
                return ++$count;
            });
        };

        $this->assertSame(1, $func());
        $this->assertSame(1, $func());
        $this->assertSame(1, $func());

        return [$memo, $count, $func];
    }

    /**
     * @depends testInnerProcessIsCalledOnlyOnceWhenMultipleCalls
     *
     * @phpstan-param DependsData $data
     *
     * @phpstan-return DependsData
     */
    public function testInnerProcessIsCalledOnlyOnceAgainAfterCleared(array $data): array
    {
        list($memo, $count, $func) = $data;

        $memo->clear('foo');
        $this->assertSame(2, $func());
        $this->assertSame(2, $func());
        $this->assertSame(2, $func());

        $memo->clear('foo');
        $this->assertSame(3, $func());
        $this->assertSame(3, $func());
        $this->assertSame(3, $func());

        return [$memo, $count, $func];
    }

    public function testInnerProcessIsCalledOnlyOnceWhenMultipleCallsAndReturnValueIsNull(): void
    {
        $memo = new Memoization();
        $count = 0;

        $func = function () use ($memo, &$count) {
            return $memo->memoize('foo', function () use (&$count) {
                ++$count;

                return null;
            });
        };

        $this->assertSame(0, $count);

        $this->assertNull($func());
        $this->assertSame(1, $count);
        $this->assertNull($func());
        $this->assertSame(1, $count);
        $this->assertNull($func());
        $this->assertSame(1, $count);

        $memo->clear('foo');
        $this->assertNull($func());
        $this->assertSame(2, $count);
        $this->assertNull($func());
        $this->assertSame(2, $count);
    }

    public function testClearAllWillDeleteAllCaches(): void
    {
        $memo = new Memoization();
        $count1 = 0;
        $count2 = 0;

        $func1 = function () use ($memo, &$count1) {
            return $memo->memoize('foo', function () use (&$count1) {
                return ++$count1;
            });
        };

        $func2 = function () use ($memo, &$count2) {
            return $memo->memoize('bar', function () use (&$count2) {
                return ++$count2;
            });
        };

        $this->assertSame(1, $func1());
        $this->assertSame(1, $func1());
        $this->assertSame(1, $func2());
        $this->assertSame(1, $func2());

        $memo->clearAll();
        $this->assertSame(2, $func1());
        $this->assertSame(2, $func1());
        $this->assertSame(2, $func2());
        $this->assertSame(2, $func2());
    }
}
