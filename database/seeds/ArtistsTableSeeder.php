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
            'name' => 'Chi Pu',
            'avatar' => 'avatars/artists/chipu.jpg'
        ]);

        Artist::create([
            'name' => 'Đạt G',
            'avatar' => 'avatars/artists/datg.jpg'
        ]);

        Artist::create([
            'name' => 'Tóc Tiên',
            'avatar' => 'avatars/artists/toctien.jpg'
        ]);

        Artist::create([
            'name' => 'Da LAB',
            'avatar' => 'avatars/artists/dalab.jpg'
        ]);

        Artist::create([
            'name' => 'Touliver',
            'avatar' => 'avatars/artists/touliver.jpg'
        ]);

        Artist::create([
            'name' => 'Hiền Hồ',
            'avatar' => 'avatars/artists/hienho.jpg'
        ]);

        Artist::create([
            'name' => 'Sơn Tùng MTP',
            'avatar' => 'avatars/artists/sontungmtp.jpg'
        ]);

        Artist::create([
            'name' => 'Trịnh Đình Quang',
            'avatar' => 'avatars/artists/trinhdinhquang.jpg'
        ]);

        Artist::create([
            'name' => 'Đức Phúc',
            'avatar' => 'avatars/artists/ducphuc.jpg'
        ]);

        Artist::create([
            'name' => 'Quân A.P',
            'avatar' => 'avatars/artists/quanap.jpg'
        ]);
    }
}
