<?php

namespace App\Models;

use App\Models\Cinema;
use Illuminate\Http\UploadedFile;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\StoreFilmRequest;

class Film extends Model
{
    protected $table = "films";

    protected $fillable = [
        "title",
        "poster_image_url",
        "release_date",
        "duration"
    ];

    public function Cinemas()
    {
        return $this->belongsToMany(Cinema::class)
            ->as("film_schedule")
            ->withPivot(["id", "ticket_price", "airing_datetime", "seats_status"]);
    }

    public function deleteImage()
    {
        Storage::disk("public")->delete($this->poster_image_url);
    }

    public function saveImage(UploadedFile $file)
    {
        $image_url = $file->storePublicly();
        $this->poster_image_url = $image_url;
        $this->save();
    }

    public static function createSpecial(StoreFilmRequest $storeFilmRequest)
    {
        $validated = $storeFilmRequest->validated();
        $image_url = $storeFilmRequest->file("poster")->storePublicly();

        $attributes = [
            "title" => $validated["title"],
            "poster_image_url" => $image_url,
            "release_date" => $validated["release_date"],
            "duration" => $validated["duration"]
        ];
        Film::create($attributes);
    }

    public function updateSpecial(array $attributes)
    {
        $this->title = $attributes["title"];
        $this->release_date = $attributes["release_date"];
        $this->duration = $attributes["duration"];
        $this->save();
    }
}
