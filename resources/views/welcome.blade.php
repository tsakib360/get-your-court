@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Book Your Court') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <div class="form-group row">
                            <label for="area" class="col-md-4 col-form-label text-md-right">{{ __('Area') }}</label>

                            <div class="col-md-6">
                                <select name="area" class="form-control @error('area') is-invalid @enderror" id="area">
                                    <option value="">--Select a area--</option>
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
                                <select name="game" class="form-control @error('game') is-invalid @enderror" id="game">
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
@endsection
