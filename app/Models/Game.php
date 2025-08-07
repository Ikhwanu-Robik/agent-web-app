<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;
use App\Http\Requests\StoreGameRequest;
use Illuminate\Support\Facades\Storage;

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
        $pathName = $file->storePublicly('game_icons');
        $this->icon = $pathName;
        $this->save();
    }

    public static function createSpecial(StoreGameRequest $storeGameRequest)
    {
        $validated = $storeGameRequest->validated();
        $pathName = $storeGameRequest->file('icon')->storePublicly('game_icons');

        Game::create([
            'name' => $validated['name'],
            'icon' => $pathName,
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
