<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use App\Models\PersonGenerator;
use JsonSerializable;

/**
 * Class NewsBlock
 * @package App
 * @mixin Builder
 */
class Psychic extends Model implements JsonSerializable
{

    public int $hypothesis;

    public int $score;

    public int $success;

    public int $fails;

    public int $age;

    public string $title;

    public string $fio;

    public string $picture;

    private array $trys;

    public function __construct(array $array=null)
    {

        if($array == null){
            $this->newPsychicInit();
            return;
        }

        try {
            $this->hypothesis=$array['hypothesis'];
            $this->score=$array['score'];
            $this->success=$array['success'];
            $this->fails=$array['fails'];
            $this->age=$array['age'];
            $this->title=$array['title'];
            $this->fio=$array['fio'];
            $this->picture=$array['picture'];
            $this->trys=$array['trys'];
        } catch (\Throwable $th) {
            $this->newPsychicInit();
        }

    }

    public function newPsychicInit(): void
    {

        $this->hypothesis=0;

        $this->score=0;

        $this->success=0;

        $this->fails=0;

        $person = PersonGenerator::getPerson();

        $this->age = $person ['age'];

        $this->title = $person ['title'];

        $this->fio = $person ['fio'];

        $this->picture = $person ['picture'];

        $this->trys = [];

    }

    public static function takeFromArray(array $array) : Psychic
    {
        return new self($array);
    }

    public function jsonSerialize() : array
    {

        return [
            'hypothesis' => $this->hypothesis,
            'score' => $this->score,
            'success' => $this->success,
            'fails' => $this->fails,
            'age' => $this->age,
            'title' => $this->title,
            'fio' => $this->fio,
            'picture' => $this->picture,
            'trys' => $this->trys,
        ];

    }

    public function resultsToString(): string
    {
        $val = implode(',', $this->trys);

        return $val;
    }

    public function makeJob() : void
    {
        $this->hypothesis=rand(10,99);
        array_push($this->trys,$this->hypothesis);
    }
    public function clearJob() : void
    {
        $this->hypothesis=0;
    }



    public function checkResult(int $no) : bool
    {

        if($this->hypothesis == $no){
            $this->score++;
            $this->success++;
            return true;
        }

        $this->score--;
        $this->fails++;
        return false;

    }

}
