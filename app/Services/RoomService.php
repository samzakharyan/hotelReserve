<?php 

namespace App\Services;

use App\Models\Reserve;
use App\Models\Room;
use Illuminate\Database\Eloquent\Model;

class RoomService {
    
    /**
     * 
     * Create new room 
     *
     * @param array $data
     * @return Model
     */
    public function create(array $data): Model
    {
        return Room::query()->create($data);
    }

    /**
     * 
     * Update room information
     *
     * @param array $data
     * @param integer $roomId
     * @return boolean
     */
    public function update(
        array $data, int $roomId
    ): bool
    {
        return Room::query()
            ->findOrFail($roomId)
            ->update($data);
    }

    /**
     * 
     * Reserve room
     *
     * @param array $data
     * @param integer $roomId
     * @return Model
     */
    public function reserve(
        array $data, 
        int $roomId
    ): Model
    {
        $data['room_id'] = $roomId;
        $data['user_id'] = auth()->user()->id;
        Room::find($roomId)->update(['status' => 'RESERVED']);
        return Reserve::query()->create($data);
    }
}