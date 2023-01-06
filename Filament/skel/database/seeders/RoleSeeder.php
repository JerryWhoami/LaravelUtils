<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
  public $tableName = "roles";
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    $this->createAdminRole();
  }

  protected function createAdminRole() {
    DB::table($this->tableName)->insert([
      'name' => 'ADMIN',
      'title' => 'Administradores',
      'is_active' => true,
      'is_admin' => true,
      'perm' => null,
    ]);

  }
}
