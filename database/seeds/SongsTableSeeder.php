<?php

use App\Artist;
use App\Song;
use Illuminate\Database\Seeder;

class SongsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Song::create([
            'name' => 'Anh ơi ở lại',
            'other_name' => 'Cám Tấm',
            'thumbnail' => 'songs/thumbnail/AnhOiOLai.jpg',
            'url' => 'songs/anhoiolai.mp3'
        ])->setArtist('Chi Pu', 'Đạt G');

        Song::create([
            'name' => 'Nước mắt em lau bằng tình yêu mới',
            'thumbnail' => 'songs/thumbnail/NuocMatEmLauBangTinhYeuMoi.jpg',
            'url' => 'songs/nuocmatemlaubangtinhyeumoi.mp3'
        ])->setArtist('Da LAB', 'Tóc Tiên');

        Song::create([
            'name' => 'Có ai thương em như anh',
            'other_name' => '#CATENA',
            'thumbnail' => 'songs/thumbnail/CoAiThuongEmNhuAnh.jpg',
            'url' => 'songs/catena.mp3'
        ])->setArtist('Tóc Tiên', 'Touliver');

        Song::create([
            'name' => 'Rồi người thương cũng hóa người dưng',
            'thumbnail' => 'songs/thumbnail/RoiNguoiThuongCungHoaNguoiDung.jpg',
            'url' => 'songs/roinguoithuongcunghoanguoidung.mp3'
        ])->setArtist('Hiền Hồ');

        Song::create([
            'name' => 'Lạc trôi',
            'thumbnail' => 'songs/thumbnail/LacTroi.jpg',
            'url' => 'songs/lactroi.mp3'
        ])->setArtist('Sơn Tùng MTP');

        Song::create([
            'name' => 'Buồn lắm em ơi',
            'thumbnail' => 'songs/thumbnail/buonlamemoi.jpg',
            'url' => 'songs/buonlamemoi.mp3'
        ])->setArtist('Trịnh Đình Quang');

        Song::create([
            'name' => 'Hết thương cạn nhớ',
            'thumbnail' => 'songs/thumbnail/hetthuongcannho.jpg',
            'url' => 'songs/hetthuongcannho.mp3'
        ])->setArtist('Đức Phúc');

        Song::create([
            'name' => 'Còn gì đau hơn chữ đã từng',
            'thumbnail' => 'songs/thumbnail/ConGiDauHonChuDaTung.jpg',
            'url' => 'songs/ConGiDauHonChuDaTung.mp3'
        ])->setArtist('Quân A.P');
    }
}
