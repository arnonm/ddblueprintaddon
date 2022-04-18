<?php
declare(strict_types=1);

namespace Arnonm\DDBlueprintAddon\Contracts;

use Closure;

interface Task
{
    public function handle(array $data, Closure $next): array;
}
