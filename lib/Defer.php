<?php

namespace Pex;

class Defer
{
    private $fns = [];

    public function __destruct()
    {
        $this->run();
    }

    public function add(callable $fn): void
    {
        $this->fns[] = $fn;
    }

    public function run(): void
    {
        foreach (array_reverse($this->fns) as $fn) {
            $fn();
        }
        $this->fns = [];
    }
}
