<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PublicInfo extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        for ($i=0;$i<10;$i++){
            $publicInfo=new \App\Models\PublicInfo();
            $publicInfo->title='Weekly epidemiological update on COVID-19 - 27 April 2021';
            $publicInfo->desc='Globally, new COVID-19 cases increased for the ninth consecutive week, with nearly 5.7 million new cases reported in the last week – surpassing previous peaks.';

            $publicInfo->save();

        }
    }
}
