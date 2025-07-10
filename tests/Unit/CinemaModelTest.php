<?php

use App\Models\Cinema;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('Ensure that App/Models/Cinema is connected properly with cinemas table', function () {
    expect(Cinema::all())->toBeObject();
});
