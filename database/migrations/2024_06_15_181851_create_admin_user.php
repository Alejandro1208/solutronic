<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        \App\Models\User::create([
            'name' => 'Desarrollador Usuario',
            'email' => 'alejandroramonsabater@hotmail.com',
            'password' => bcrypt('Giovanni2906.'),
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {

    }
};
