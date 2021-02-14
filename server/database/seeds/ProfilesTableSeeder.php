<?php

use Illuminate\Database\Seeder;
use App\Models\Profile;
use App\Models\User;

class ProfilesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = User::get();

        foreach ($users as $user) {
            if ( Profile::where('user_id', $user->id)->first() === null ) {
                factory(Profile::class)->create([
                    'user_id' => $user->id
                ]);
            }
        }
    }
}
