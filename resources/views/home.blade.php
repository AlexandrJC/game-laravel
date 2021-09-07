@extends('layouts.layout')

@section('content')

  <div class="album py-5 bg-light">
    <div class="mx-auto" style="width: 150px; height:180px;">
        <h1>Маги</h1>
        <a href="#" class="btn btn-primary my-2" id="start">Начать игру</a><br>
        <p></p>
        Было попыток : {{$player->takeTrys()}}
    </div>
    <div class="container">
      <div class="row row-cols-1 row-cols-sm-2 row-cols-md-24 g-3">

            <svg class="bd-placeholder-img card-img-top" width="100%" height="100" xmlns="http://www.w3.org/2000/svg" aria-label="Placeholder: Thumbnail" preserveAspectRatio="xMidYMid slice" focusable="false">
                <rect width="100%" height="100%" fill="#55595c"></rect>
                <text x="50%" y="50%" fill="#eceeef" dy=".3em" font-size="16px">
                    История загаданных чисел:
                    {{$player->toString()}}
                </text>
            </svg>


      </div>

      <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3">

        @foreach($psychics as $psychic)

        <div class="col" id="col{{$psychic->id}}">
            <div class="card shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="btn-group">
                         @if ($psychic->score< 0)
                            <span class="btn btn-sm btn-danger">
                         @else
                            <span class="btn btn-sm btn-success" >
                         @endif

                         Рейтинг : {{$psychic->score}}  </span>

                         <span class="btn btn-sm btn-outline-secondary"> Угадал : {{$psychic->success}}</span>
                         <span class="btn btn-sm btn-outline-secondary"> Мимо : {{$psychic->fails}}</span>
                        </div>
                    </div>
                </div>
              <div id="block{{$psychic->id}}">

              <a href="">
                <svg class="bd-placeholder-img card-img-top" width="100%" height="225" xmlns="http://www.w3.org/2000/svg" aria-label="Placeholder: Thumbnail" preserveAspectRatio="xMidYMid slice" focusable="false">
                    <title>Игрок</title>
                    <rect width="100%" height="100%" fill="#55595c"></rect>
                    <text x="50%" y="50%" fill="#eceeef" dy=".3em" font-size="80px">{{$psychic->picture}}</text>
                </svg>
              </a>

              <div class="card-body">
                <h3>{{$psychic->title}}:</h3>
                <p class="card-text">
                    <h5>{{$psychic->fio}}</h5>
                </p>
                <p class="card-text">
                    Возраст: {{$psychic->age}}
                </p>
                <p>
                История ответов:
                <div class="d-flex justify-content-between align-items-center">

                  <div class="btn-group">
                    {{$psychic->resultsToString()}}
                  </div>
                 <!-- <small class="text-muted">Опубликовано </small> -->
                </div>
                </div>
              </div>
            </div>
          </div>

       @endforeach

      </div>
    </div>
  </div>

  <script>

    $('#start').click(function(){
        WorkerRequestOperation('{{route('startgame') }}');
    });

    function closeModal() {

        $("#resultModal").modal('hide');
    };

    function makeBet(){

        data={
            nomber: $('#nomber').val(),
        };

        WorkerRequestOperation('{{route('makebet')}}', data);

    }

    function WorkerRequestOperation(url, data = null)
    {
        var id;

        if(data !=null && "id" in data){
            id=data['id'];
        }

        $.ajax({

            url: url,

            type: "POST",

            data: data,

            headers: {

            'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')

            },

            success: function (data) {


                $('#resultMessage').html(data);

                var btnline='<button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="location.reload();">Закрыть</button>';

                if(url==="{{route('startgame') }}" || data.includes('alert alert-danger')){
                    $('#resultModalLabel').html("Загадайте число");

                    btnline='<button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="closeModal()">Закрыть</button> \
                             <button type="button" class="btn btn-primary" onclick="makeBet()">Загадал</button>';

                }

                $('#buttonline').html(btnline);

                $('#resultModal').modal('show');


            },

            error: function (msg) {

                alert('Ошибка');

            }

        });
    }



    </script>
<!-- Modal -->

@include('layouts.modal')






@endsection

