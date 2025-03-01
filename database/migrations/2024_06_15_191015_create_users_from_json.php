DB::table('users')->where('email', 'alejandroramonsabater@hotmail.com')->delete();<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\User;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        $users = json_decode(file_get_contents(database_path('users.json')), true);
    
        foreach ($users as $user) {
            if (!User::where('email', $user['email'])->exists()) {
                User::create([
                    'name' => $user['name'],
                    'email' => $user['email'],
                    'password' => bcrypt($user['password']),
                ]);
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Si necesitas revertir algo específico
    }
};
