@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <table class="table">
                    <thead>
                      <tr>
                        <th scope="col">#</th>
                        <th scope="col">Area</th>
                        <th scope="col">Game</th>
                        <th scope="col">Field</th>
                        <th scope="col">Time From</th>
                        <th scope="col">Time To</th>
                        <th scope="col">Status</th>
                      </tr>
                    </thead>
                    <tbody>
                        @foreach ($books as $book)
                            <tr>
                                <th scope="row">*</th>
                                <td>{{$book->area->name}}</td>
                                <td>{{$book->game->name}}</td>
                                <td>{{$book->field->name}}</td>
                                <td>{{$book->booking_at === ""|| $book->booking_at === null ? "Still Not Booked" : $book->booking_at->format('jS F Y h:i:s A') }}</td>
                                <td>{{$book->booking_time === ""|| $book->booking_time === null ? "Still Not Booked" : $book->booking_time->format('jS F Y h:i:s A') }}</td>
                                @if ($book->approve == 0)
                                <td>Pending</td>
                                @elseif($book->approve == 1)
                                    <td>Approved</td>
                                @else
                                    <td>Closed</td>

                                @endif

                            </tr>
                        @endforeach

                    </tbody>
                  </table>
            </div>
        </div>
    </div>
</div>
@endsection
