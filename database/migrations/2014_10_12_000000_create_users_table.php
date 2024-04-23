<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('role_id');
            $table->foreign('role_id')->references('id')->on('roles')->onDelete('cascade');
            $table->string('full_name');
            $table->string('email')->unique();
            $table->string('password');
            $table->string('avatar')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });

        DB::table('users')->insert([
            'full_name' => 'Entrenador 1',
            'email' => 'entrenador1@test.com',
            'password' => bcrypt('12345678'),
            'role_id' => 1,
        ]);

        DB::table('users')->insert([
            'full_name' => 'Corredor 1',
            'email' => 'corredor1@test.com',
            'password' => bcrypt('12345678'),
            'role_id' => 2,
        ]);

        DB::table('users')->insert([
            'full_name' => 'Corredor 2',
            'email' => 'corredor2@test.com',
            'password' => bcrypt('12345678'),
            'role_id' => 2,
        ]);

        DB::table('users')->insert([
            'full_name' => 'Corredor 3',
            'email' => 'corredor3@test.com',
            'password' => bcrypt('12345678'),
            'role_id' => 2,
        ]);

        DB::table('users')->insert([
            'full_name' => 'Corredor 4',
            'email' => 'corredor4@test.com',
            'password' => bcrypt('12345678'),
            'role_id' => 2,
        ]);

        DB::table('users')->insert([
            'full_name' => 'Corredor 5',
            'email' => 'corredor5@test.com',
            'password' => bcrypt('12345678'),
            'role_id' => 2,
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
