@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Book Your Court') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <form method="POST" action="{{ route('book.court') }}">
                        @csrf

                        <div class="form-group row">
                            <label for="area" class="col-md-4 col-form-label text-md-right">{{ __('Area') }}</label>

                            <div class="col-md-6">
                                <select name="area" class="form-control @error('area') is-invalid @enderror" id="area" onclick="fetchGame(this.value)">
                                    <option value="">--Select a area--</option>
                                    @foreach ($areas as $area)
                                        <option value="{{$area->id}}">{{$area->name}}</option>
                                    @endforeach
                                </select>

                                @error('area')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="game" class="col-md-4 col-form-label text-md-right">{{ __('Types of Game') }}</label>

                            <div class="col-md-6">
                                <select name="game" class="form-control @error('game') is-invalid @enderror" id="game" onclick="fetchField(this.value)">
                                    <option value="">--Select a game--</option>
                                </select>

                                @error('game')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="field" class="col-md-4 col-form-label text-md-right">{{ __('Fields') }}</label>

                            <div class="col-md-6">
                                <select name="field" class="form-control @error('field') is-invalid @enderror" id="field">
                                    <option value="">--Select a field--</option>
                                </select>

                                @error('field')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-md-4 col-form-label text-md-right">{{ __('Time From') }}</label>

                            <div class="col-md-3">
                                <input type="date" class="form-control @error('time_at') is-invalid @enderror" name="time_at_d" required>
                            </div>

                            <div class="col-md-3">
                                <input type="time" class="form-control @error('time_at') is-invalid @enderror" name="time_at_t" required>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-md-4 col-form-label text-md-right">{{ __('Time To') }}</label>

                            <div class="col-md-3">
                                <input type="date" class="form-control @error('booking_time') is-invalid @enderror" name="booking_time_d" required>
                            </div>

                            <div class="col-md-3">
                                <input type="time" class="form-control @error('booking_time') is-invalid @enderror" name="booking_time_t" required>
                            </div>
                        </div>
                        
                        @auth
                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Book Now') }}
                                </button>
                            </div>
                        </div>
                        @else
                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <a href="{{ route('login') }}" class="btn btn-primary" onclick="return confirm('You are not logged in. Please login first!')">
                                    {{ __('Book Now') }}
                                </a>
                            </div>
                        </div>
                        @endif
                        
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
                url: '/games/get/'+id,
                type:"GET",
                dataType:"json",
                // beforeSend: function(){
                //     $('#loader').css("visibility", "visible");
                // },

                success:function(data) {

                    $('select[name="game"]').empty();

                    $.each(data, function(key, value){

                        $('select[name="game"]').append('<option value="'+ key +'">' + value + '</option>');

                    });
                },
                // complete: function(){
                //     $('#loader').css("visibility", "hidden");
                // }
            });
    }

    function fetchField(id)
    {
        $.ajax({
                url: '/fields/get/'+id,
                type:"GET",
                dataType:"json",
                // beforeSend: function(){
                //     $('#loader').css("visibility", "visible");
                // },

                success:function(data) {

                    $('select[name="field"]').empty();
                    $('select[name="field"]').append('<option value="">Select</option>');

                    $.each(data, function(key, value){

                        $('select[name="field"]').append('<option value="'+ key +'">' + value + '</option>');

                    });
                },
                // complete: function(){
                //     $('#loader').css("visibility", "hidden");
                // }
            });
    }
</script>
@endsection
