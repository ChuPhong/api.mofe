<?php

use App\Artist;
use Illuminate\Database\Seeder;

class ArtistsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Artist::create([
            'name' => 'Chi Pu'
        ]);

        Artist::create([
            'name' => 'Đạt G'
        ]);

        Artist::create([
            'name' => 'Tóc Tiên'
        ]);

        Artist::create([
            'name' => 'Da LAB'
        ]);

        Artist::create([
            'name' => 'Touliver'
        ]);

        Artist::create([
            'name' => 'Hiền Hồ'
        ]);

        Artist::create([
            'name' => 'Sơn Tùng MTP'
        ]);

        Artist::create([
            'name' => 'Trịnh Đình Quang'
        ]);

        Artist::create([
            'name' => 'Đức Phúc'
        ]);

        Artist::create([
            'name' => 'Quân A.P',
        ]);
    }
}
