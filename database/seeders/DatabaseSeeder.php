<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Artist;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $artists =[
            ['name'=> 'Sifaeli Mwabuka','phone'=> '254718345852', 'limit'=> 535277.0],
            ['name' => 'St Joseph Catholic Choir Kendu Bay', 'phone' => '254718768800', 'limit' =>  98079.04],
            ['name' => 'Hannington', 'phone' => '254725397081','limit'=>  96788.70],
            ['name' => 'Justus Miyello', 'phone' => '254114706582','limit' =>  86635.38],
            ['name' => 'Rosemary George', 'phone' => '254727277378','limit' =>  65593.00],
            ['name' => 'Stephen Kasolo', 'phone' => '254721510514', 'limit' =>  49380.68],
            ['name' => 'Fenny Kerubo', 'phone' => '254716232675', 'limit' =>  45955.40],
            ['name' => 'Tumaini', 'phone' => '254723633522', 'limit'=> 44227.04],
        ];

        foreach($artists as $data){
            $artist = Artist::create(['name'=>$data['name'], 'phone'=>$data['phone']]);
            $limit = floor($data['limit'] * 0.49);
            $artist->amountLimit()->create(["royalties"=>$data['limit'], "advance_limit"=>$limit]);
        }
    }
}
