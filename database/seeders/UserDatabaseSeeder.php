<?php
namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class UserDatabaseSeeder extends Seeder
{
	/**
     * Run the database seeds.
     *
     * @return void
     */
	public function run()
    {
    	Model::unguard();
    	User::create([
            'name' => 'System User',
            'email' => 'test@gmail.com',
            'password' => bcrypt('secret123')
        ]);
    }
}