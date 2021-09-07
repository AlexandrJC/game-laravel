<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PersonGenerator extends Model
{
    private static $FioData = array(
		"0" => array (
			"names" => array("Александра", "Мария", "Ольга", "Дарья"),
			"middlenames" => array("Александровна", "Викторовна", "Ивановна", "Сергеевна"),
			"lastnames" => array("Александрова", "Сергеева", "Владимирова", "Иванова"),
		),
		"1" => array(
			"names" => array("Александр", "Сергей", "Владимир", "Иван"),
			"middlenames" => array("Александрович", "Викторович", "Иванович", "Сергеевич"),
			"lastnames" => array("Александров", "Сергеев", "Владимиров", "Иванов"),
		)

	);

    private static $PicsData = [
        '😀','😁','😂','🤣','😃','😄','😅','😆','😊','😋','😎','😍','😘','😗','😙','😚',
        '🙂','🤗','🤩','🤔','🤨','😐','😑','😶','🙄','😏','😣','😥','😮','🤐','😯','😪',
        '😫','😴','😌','😛','😜','🤤','😒','😓','😔','😕','🙃','🤑','😲','🙁','😖','😞',
        '😟','😤','😢','😭','😦','😧','😨','😩','🤯','😬','😰','😱','😳','🤪','😵','😡',
        '😠','🤬','😷','🤒','🤕','🤢','🤮','🤧'
        ];

    private static $TitleData = ['Ведьма', 'Колдун'];

    public static function getPerson(): array
    {

        $gender = rand(0,1);

        return ['age' => rand(20,120),
                'title' => self::$TitleData[$gender],
                'fio' => self::GetFio($gender),
                'picture' => self::getPicture()
        ];

    }

    private static function getPicture()
	{
        return self::$PicsData[rand(0,count(self::$PicsData)-1)];
    }

    private static function getFio($sex)
	{
		$fios=self::$FioData[$sex];
 		$name = $fios["names"][rand(0,count($fios["names"])-1)];
 		$middle = $fios["middlenames"][rand(0,count($fios["middlenames"])-1)];
 		$last = $fios["lastnames"][rand(0,count($fios["lastnames"])-1)];

		return $last." ".$name." ".$middle;
	}

}
