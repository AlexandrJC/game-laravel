<?php

namespace App\Models;

use App\Interfaces\ILocalStorrage;
use \Illuminate\Support\Facades\Session;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class SessionStorrage implements ILocalStorrage
{
    public function Load(string $key) : ?string
    {

        $session = Session::get($key);

        return $session;
    }

    public function Save(string $key, string $json)
    {
        Session::put($key , $json);

    }

    public function IsFirstLoad():bool
    {
        if(session()->get('is_first_time') == null){
            return true;
        }

        return false;
    }

    public function Clear():void
    {
        Session::flush();
    }

}

