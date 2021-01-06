<?php

namespace Database\Seeders;

use App\Models\Company;
use App\Models\Student;
use App\Models\Tutor;
use App\Models\User;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */

    public function run()
    {
       $tutor = Tutor::factory()
       ->create([
            'company_id' => Company::query()->get()->first()->getKey(),
            'user_id' =>   User::factory()->create([
                'email' => 'admin@dev.com',
                'is_admin' => 1,
            ])
        ]);
        Student::query()->inRandomOrder()->limit(2)->get()->each(function ($student) use ($tutor) {
            $student->tutor()->associate($tutor);
            $student->saveOrFail();
        });
    }
}
