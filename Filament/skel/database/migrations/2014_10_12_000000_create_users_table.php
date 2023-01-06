<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('users', function (Blueprint $table) {
      $table->id();
      $table->foreignId('role_id')
      ->nullable()
      ->constrained()
      ->nullOnDelete();
      $table->string('username')->default('admin')->unique();
      $table->string('name');
      $table->string('email')->unique();
      $table->string('password');
      $table->boolean('is_active')->nullable()->default(true);
      $table->boolean('is_blocked')->nullable()->default(false);
      $table->string('block_reason')->nullable();
      $table->timestamp('expires_at')->nullable();
      $table->timestamp('email_verified_at')->nullable();
      $table->string('avatar')->nullable();
      $table->string('last_login_ip')->nullable();
      $table->timestamp('last_login_at')->nullable();
      $table->rememberToken();
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::dropIfExists('users');
  }
};
