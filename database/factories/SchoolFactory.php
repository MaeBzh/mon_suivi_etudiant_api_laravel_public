<?php

namespace Database\Factories;

use App\Models\Address;
use App\Models\School;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

class SchoolFactory extends Factory
{
    protected $model = School::class;

    public function definition()
    {
        // $old_path = public_path('/img/campus_academy_logo.jpg');
        // $new_path = public_path('img/' . Str::uuid()->toString() . '.jpg');

        // Image::make($old_path)
        //     ->resize(120, 120, function ($constraint) {
        //         $constraint->aspectRatio();
        //         $constraint->upsize();
        //     })
        //     ->save($new_path, 90, 'jpg');
        return [
            'name' => $this->faker->company,
            'address_id' => function () {
                return Address::factory();
            },
            // 'logo' => base64_encode(file_get_contents($new_path)),
        ];
    }
}

