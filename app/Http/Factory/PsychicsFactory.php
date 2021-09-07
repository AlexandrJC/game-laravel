<?php

namespace App\Http\Factory;

use Illuminate\Http\Request;
use App\Models\Psychic;
use App\Models\SessionStorrage;
use App\Interfaces\ILocalStorrage;
use Illuminate\Support\Facades\Validator;


class PsychicsFactory{

    private array $Psychics = [];

    private int $Min = 6;

    private int $Max = 12;

    private string $Key = 'Psychics';

    private ILocalStorrage $Storrage;

    public function __construct(ILocalStorrage $storrage)
    {

        $this->Storrage = $storrage;

        if($this->Storrage->Load($this->Key) == null){
            $this->generatePsychics();
        }
        else{
            $this->loadPsychics();
        }

    }

    public function generatePsychics(){

        $amount = rand($this->Min,$this->Max);

        for ($i=0; $i < $amount; $i++) {
           $this->Psychics[$i] = new Psychic();
        }

        $this->saveData();

    }

    public function takeAll(){
        return $this->Psychics;
    }

    private function saveData(){

        $this->Storrage->Save($this->Key, json_encode($this->Psychics));

    }

    public function loadPsychics(){

        $json = $this->Storrage->Load($this->Key);

        $pychics_arr=json_decode($json, true);

        foreach ($pychics_arr as $item)
        {
            array_push($this->Psychics,Psychic::takeFromArray($item));
        }

        $this->saveData();

    }

    public function allMakeJob(){

        foreach ($this->Psychics as &$item) {
            $item->makeJob();
        }

        $this->saveData();

    }

    public function allClearJob(){

        foreach ($this->Psychics as &$item) {
            $item->clearJob();
        }

        $this->saveData();

    }




    public function allCheckResult(int $no): array
    {

        $best = [];

        foreach ($this->Psychics as &$item) {
            if($item->checkResult($no))
            {
                array_push($best,$item);
            }
        }

        $this->saveData();

        return $best;

    }




}

