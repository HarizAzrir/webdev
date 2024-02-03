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
        Schema::create('clubs', function (Blueprint $table) {
            $table->id(); // This creates an auto-incrementing primary key column
            $table->foreignId('user_id')->constrained('users');
            $table->string('clubname');
            $table->string('club_nickname');
            
            // Change the 'about' column to a text type if it can store larger text content
            $table->text('about');
        
            $table->string('email');
            
            // Assuming 'instagram' and 'contact_number' are URLs or longer strings
            // Change them to text or a suitable data type based on your needs
            $table->text('instagram');
            $table->text('contact_number');
            $table->string('image')->nullable();
            $table->timestamps();
        
        });        
    }
 
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('clubs', function (Blueprint $table) {
            $table->dropColumn('image');
        });
    }
};
