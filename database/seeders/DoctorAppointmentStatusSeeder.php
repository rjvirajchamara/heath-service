<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DoctorAppointmentStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(){

        DB::table('doctor_appointment_statuses')->insert([[

            'status' =>'pending'
        ],[
            'status' =>'approval'
        ],[
            'status' =>'cancel'
        ],[
            'status' =>'Reschedule'
        ],[
            'status' =>'complete'
        ]
    ]);

    }
}
