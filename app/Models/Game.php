<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;
use App\Http\Requests\StoreGameRequest;

class Game extends Model
{
    protected $fillable = [
        'name',
        'icon',
        'currency'
    ];

    public function deleteImage()
    {
        Storage::disk("public")->delete($this->icon);
    }

    public function saveImage(UploadedFile $file)
    {
        $path_name = $file->storePublicly('game_icons');
        $this->icon = $path_name;
        $this->save();
    }

    public static function createSpecial(StoreGameRequest $storeGameRequest)
    {
        $validated = $storeGameRequest->validated();
        $path_name = $storeGameRequest->file('icon')->storePublicly('game_icons');

        Game::create([
            'name' => $validated['name'],
            'icon' => $path_name,
            'currency' => $validated['currency']
        ]);
    }

    public function updateSpecial(array $attributes)
    {
        $this->name = $attributes["name"];
        $this->currency = $attributes["currency"];
        $this->save();
    }
}
