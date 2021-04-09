<?php

namespace App\Http\Controllers;

use App\Http\Requests\AreaRequest;
use App\Http\Requests\FieldRequest;
use App\Http\Requests\GameRequest;
use App\Models\Area;
use App\Models\Book;
use App\Models\Field;
use App\Models\Game;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Mail\Message;
use Illuminate\Support\Facades\Mail;

class AdminController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('admin');
    }

    public function createArea()
    {
        return view('admin.createArea');
    }

    public function storeArea(AreaRequest $request)
    {
        $area = Area::create([
            'name' => $request->input('name'),
        ]);

        return redirect('admin/home')
                ->with('status','Area is created!');
    }

    public function createGame()
    {
        $areas = Area::All();
        return view('admin.createGame', compact('areas'));
    }

    public function storeGame(GameRequest $request)
    {
        $area = Game::create([
            'area_id' => $request->input('area_id'),
            'name' => $request->input('name'),
        ]);

        return redirect('admin/home')
                ->with('status','Game is created!');
    }

    public function getGame($id)
    {
        $games = Game::where('area_id', $id)->pluck('name', 'id');
        return json_encode($games);
    }

    public function createField()
    {
        $areas = Area::All();
        return view('admin.createField', compact('areas'));
    }

    public function storeField(FieldRequest $request)
    {
        $area = Field::create([
            'game_id' => $request->input('game_id'),
            'name' => $request->input('name'),
        ]);

        return redirect('admin/home')
                ->with('status','Court is created!');
    }

    public function bookList()
    {
        $books = Book::with(['game', 'area', 'field'])->get();
        return view('admin.bookList', compact('books'));
    }

    public function bookApprove($id)
    {
        // get the current time
        $current = Carbon::now();
        $book = Book::find($id);
        // $book['booking_at'] = $current;
        // $book['booking_time'] = $current->addHour(2);
        $uid = $book['user_id'];
        $user= User::where('id', $uid)->first();
        $email = $user->email;
        $book['approve'] = 1;
        $book->save();

        Mail::send('Mails.admin', [], function (Message $message) use($email) {
            $message->to($email);
            $message->subject('Booking Confirm!');
        });
        return redirect('/admin/home')->with('status', 'Book aproved');
    }

    public function bookClose($id)
    {
        $book = Book::find($id);
        $book['approve'] = 2;
        $book->save();
        return redirect('/admin/home')->with('status', 'Book Closed');
    }
}
