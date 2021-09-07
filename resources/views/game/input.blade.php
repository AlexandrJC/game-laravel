<div class="container">

    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form method="post" action="{{ route('makebet') }}">
        @csrf

        @if(isset($psychics))

            @foreach ($psychics as $psychic)

            <div class="form-group">
                {{$psychic->hypothesis}} || {{$psychic->title}} : {{$psychic->fio}} {{$psychic->picture}}
            </div>

            @endforeach

        @endif

        <div class="form-group">
            <label for="name">Введите двузначное число:</label>
            <input type="text" class="form-control" id="nomber" name="nomber">
        </div>

    </form>

</div>

