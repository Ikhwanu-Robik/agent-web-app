<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;

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

    public function updateSpecial(array $attributes)
    {
        $this->name = $attributes["name"];
        $this->currency = $attributes["currency"];
        $this->save();
    }
}
