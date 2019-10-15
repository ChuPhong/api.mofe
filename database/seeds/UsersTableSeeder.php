<?php

use App\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'Chu Cẩm Phong',
            'email' => 'admin@gmail.com',
            'password' => 'password',
        ])->syncRoles('admin');

        User::create([
            'name' => 'Trần Duy Anh',
            'email' => 'tranduyanh@gmail.com',
            'password' => 'password',
        ])->syncRoles('moderator');
    }
}
