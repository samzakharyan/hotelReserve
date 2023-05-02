<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddRoomRequest;
use App\Http\Requests\ReserveRequest;
use App\Http\Requests\UpdateRoomRequest;
use App\Models\Reserve;
use App\Models\Room;
use App\Services\RoomService;
use Illuminate\Contracts\View\View;
use Illuminate\Contracts\View\Factory;

class RoomController extends Controller
{

    public function __construct(
        public RoomService $service 
    ){
        //
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): View|Factory
    {
        if (auth()->user()->role === 'ADMIN') {
            $rooms = Room::query()->with(['reserve' => fn($item) => $item->with('user')])->paginate(8);

            return view('home', compact('rooms'));

        } else {
            $rooms = Room::query()->where(['status' => 'FREE'])->with('reserve')->paginate(8);
            $myReserves = Reserve::query()->where(['user_id' => auth()->user()->id])->with('rooms')->get();

            return view('home', compact('rooms', 'myReserves'));
        }

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('add');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AddRoomRequest $request)
    {
        $this->service->create($request->validated());

        return redirect()->route('home');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id): View|Factory
    {
        $room = Room::findOrFail($id);
        
        return view('edit', compact('room'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRoomRequest $request, string $roomId)
    {
        $this->service->update($request->validated(), $roomId);

        return redirect()->route('home');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    /**
     * 
     * Reserve room page
     * 
     * @param integer $roomId
     * 
     * @return View|Factory
     */
    public function reservePage(int $roomId): View|Factory
    {
        $room = Room::findOrFail($roomId);

        return view('reserve', compact('room'));
    }

    /**
     * 
     * Reserve room page
     * 
     * @param integer $roomId
     * @param ReserveRequest $request
     * 
     * @return View|Factory
     */
    public function reserve(ReserveRequest $request, int $roomId)
    {
        $this->service->reserve($request->validated(), $roomId);

        return redirect()->route('home');
    }

    public function unset(int $roomId)
    {
        Room::find($roomId)->update(['status' => 'FREE']);
        Reserve::query()->where('room_id', $roomId)->delete();
        
        return redirect()->route('home');
    }
}
