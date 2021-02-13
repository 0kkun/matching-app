<?php

use Illuminate\Database\Seeder;
use App\Models\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $is_exist_sample_user = User::where('name', 'test')->exists();

        // サンプルユーザー
        if (!$is_exist_sample_user) {
            factory(User::class)->create([
                'name' => 'test',
                'email' => 'test@gmail.com',
                'password' => bcrypt('secret')
            ]);
        }

        factory(User::class, 10)->create();
    }
}
