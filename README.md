# Memoization

## Usage

```php

namespace App;

use Kalibora\Memoization\MemoizationTrait;

class HeavyProcessor
{
    use MemoizationTrait;

    public function process(): void
    {
        return $this->getMemoization()->memoize(__FUNCTION__, function () {
            // Very heavy processing takes place here.

            return $value;
        });
    }
}
```
