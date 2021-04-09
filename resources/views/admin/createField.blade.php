@extends('layouts.adminapp')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Creat Area') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('field.create') }}">
                        @csrf

                        <div class="form-group row">
                            <label for="area_id" class="col-md-4 col-form-label text-md-right">{{ __('Area') }}</label>

                            <div class="col-md-6">
                                <select name="area_id" class="form-control @error('area_id') is-invalid @enderror" id="area_id" onclick="fetchGame(this.value)">
                                    <option value="">--Select a area--</option>
                                    @foreach ($areas as $area)
                                        <option value="{{$area->id}}">{{$area->name}}</option>
                                    @endforeach
                                </select>

                                @error('game_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="game_id" class="col-md-4 col-form-label text-md-right">{{ __('Game') }}</label>

                            <div class="col-md-6">
                                <select name="game_id" class="form-control @error('game_id') is-invalid @enderror" id="game_id">
                                    <option value="">--Select a game--</option>
                                </select>

                                @error('game_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Field Name') }}</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Create') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function fetchGame(id)
    {
        $.ajax({
                url: '/admin/games/get/'+id,
                type:"GET",
                dataType:"json",
                // beforeSend: function(){
                //     $('#loader').css("visibility", "visible");
                // },

                success:function(data) {

                    $('select[name="game_id"]').empty();

                    $.each(data, function(key, value){

                        $('select[name="game_id"]').append('<option value="'+ key +'">' + value + '</option>');

                    });
                },
                // complete: function(){
                //     $('#loader').css("visibility", "hidden");
                // }
            });
    }
</script>
@endsection
