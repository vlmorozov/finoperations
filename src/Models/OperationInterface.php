<?php

namespace Vlmorozov\Finoperations\Models;

interface OperationInterface
{
    public function handle(): void;
}