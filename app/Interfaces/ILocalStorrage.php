<?php

namespace App\Interfaces;

interface ILocalStorrage
{
    public function IsFirstLoad() : bool;

    public function Load(string $key) : ?string;

    public function Save(string $key, string $json);

    public function Clear() : void;

}
