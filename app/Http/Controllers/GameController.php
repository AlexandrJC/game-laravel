<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Factory\PsychicsFactory;
use App\Models\SessionStorrage;
use App\Interfaces\ILocalStorrage;
use Illuminate\Support\Facades\Validator;
use App\Models\Player;
use com_exception;

class GameController extends Controller
{

    private PsychicsFactory $PsychicsFactory;

    private Player $Player;

    private ILocalStorrage $Storrage;

    public function __construct()
    {
        $this->Storrage = new SessionStorrage();
        $this->PsychicsFactory=new PsychicsFactory($this->Storrage);
        $this->Player = Player::takePlayer($this->Storrage);

    }

    public function index()
    {
        $psychics=$this->PsychicsFactory->takeAll();
        $player = $this->Player;

        return view('home',compact('psychics','player'));
    }

    public function newgame(Request $request){
        $this->Storrage->Clear();
        return redirect('/');
    }

    public function start(Request $request){

        $this->PsychicsFactory->allMakeJob();

        $psychics=$this->PsychicsFactory->takeAll();

        return view('game.input', compact('psychics'));

    }

    public function bet(Request $request){

        $rules = ['nomber'=>'required|integer|digits:2'];
        $messages = [
            'required' =>'Без числа не можем продолжить игру, оно необходимо',
            'integer' => 'Используйте только целое число в 2 знака',
            'digits' => 'Используйте только целое число между 10 и 99'
        ];

        $winers=[];

        if($request->ajax()){

            $input = $request->all();

            $validator = Validator::make($input,$rules,$messages);

            if ($validator->fails()) {

                $errors = $validator->errors();

                $psychics=$this->PsychicsFactory->takeAll();

                return view('game.input',compact('errors','psychics'));
            }

            $winers = $this->PsychicsFactory->allCheckResult($input['nomber']);

            $this->Player->updatePlayer($this->Storrage, $input['nomber']);

            $this->PsychicsFactory->allClearJob();

        }


        return view('game.result', compact('winers'));
    }


}
