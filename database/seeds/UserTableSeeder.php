<?php

use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      $user = new \App\User();
      $user->name = 'Arvind';
      $user->email = 'arvindonarayanan@gmail.com';
      $user->password = bcrypt('ggwplol');
      $user->save();
    }
}
