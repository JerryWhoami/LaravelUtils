<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
  public $tableName = "users";
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    $this->createAdminUser();
  }

  protected function createAdminUser() {
    DB::table($this->tableName)->insert([
      'role_id' => 1,
      'username' => 'admin',
      'name' => 'Admin',
      'email' => 'admin@changeme.com',
      'password' => Hash::make('password'),
      'is_active' => true,
      'is_blocked' => false,
    ]);

  }
}
