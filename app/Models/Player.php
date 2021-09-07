<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Interfaces\ILocalStorrage;
use JsonSerializable;

class Player extends Model implements JsonSerializable
{

    public array $nombers;

    public static string $key="User";

    public function __construct(array $array=null)
    {

        if($array == null){
            $this->newPlayerInit();
            return;
        }

        try {
            $this->nombers=$array['nombers'];
        } catch (\Throwable $th) {
            $this->newPlayerInit();
        }

    }

    public function newPlayerInit(): void
    {
        $this->nombers=[];
    }

    public static function takePlayer(ILocalStorrage $storrage): Player
    {

        $player_data = $storrage->Load(self::$key);

        if($player_data == null){
            $to_return = new self();
            $storrage->Save(self::$key, json_encode($to_return->nombers));
            return $to_return;
        }
        else{
            return new self(json_decode($player_data,true));
        }

    }

    public function updatePlayer(ILocalStorrage $storrage, int $nomber){

        array_push($this->nombers, $nomber);

        $storrage->Save(self::$key, json_encode(['nombers'=>$this->nombers]));

    }

    public function takeTrys(): int
    {
        return count($this->nombers);

    }

    public function toString(): string
    {
        $val = implode(',', $this->nombers);

        return $val;
    }


    public function jsonSerialize() : array
    {

        return [
            'nombers' => $this->nombers
        ];

    }

}
