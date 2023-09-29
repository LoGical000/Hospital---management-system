<?php

namespace Database\Seeders;

use App\Models\Appointment;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AppointmentSeeder extends Seeder
{

    public function run(): void
    {
        DB::table('appointments')->delete();
        $appointments = [
            ['name'=>'Saturday'],
            ['name'=>'Sunday'],
            ['name'=>'Monday'],
            ['name'=>'Tuesday'],
            ['name'=>'Wednesday'],
            ['name'=>'thursday'],
            ['name'=>'Friday'],
        ];
        foreach ($appointments as $appointment)
        Appointment::create($appointment);

    }
}
