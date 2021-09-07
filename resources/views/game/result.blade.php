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

    <div class="form-group">
        А угадал только:
    </div>

    @foreach ($winers as $winer)

        <div class="form-group">
            {{$winer->title}} : {{$winer->fio}} {{$winer->picture}}
        </div>

    @endforeach

</div>

