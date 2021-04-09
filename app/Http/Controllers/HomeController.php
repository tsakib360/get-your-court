<?php

namespace App\Http\Controllers;

use App\Models\Area;
use App\Models\Book;
use App\Models\Field;
use App\Models\Game;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Mail\Message;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $areas = Area::All();
        return view('home', compact('areas'));
    }

    public function userBooks()
    {
        $books = Book::where('user_id', '=', Auth::id())->with(['game', 'area', 'field'])->paginate(10);
        return view('bookList', compact('books'));
    }

    public function getGame($id)
    {
        $games = Game::where('area_id', $id)->pluck('name', 'id');
        return json_encode($games);
    }

    public function getField($id)
    {
        $fields = Field::where('game_id', $id)->pluck('name', 'id');
        return json_encode($fields);
    }

    public function bookCourt(Request $request)
    {
        $f =   $request->input('time_at_d').' '. $request->input('time_at_t');
        $fd= date($f);
        $t =   $request->input('booking_time_d').' '. $request->input('booking_time_t');
        $td = date($t);
        $BookExist = Book::where([['field_id', '=', $request->input('field')], ['approve', '!=', 2]])->where('booking_at', '<=', $td)->where('booking_at', '>=', $fd)->exists();
        if($BookExist == True)
        {
            return redirect('/home')->with('status', 'Field in not available');
        }
        else{
            $user= User::where('id', Auth::id())->first();
            $email = $user->email;
            $book = Book::create([
                'area_id' => $request->input('area'),
                'game_id' => $request->input('game'),
                'field_id' => $request->input('field'),
                'booking_at' => $f,
                'booking_time' => $t,
                'user_id' => Auth::id(),
                'approve' => 0,
                
            ]);

            Mail::send('Mails.confirm', [], function (Message $message) use($email) {
                $message->to($email);
                $message->subject('Booking Confirm!');
            });
    
            return redirect('/home')->with('status', 'Booking is going to admin approval.');
        }
        
    }
}
