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
            $table->string('clubname');
            $table->string('club_nickname');
            $table->string('president');
            
            // Change the 'about' column to a text type if it can store larger text content
            $table->text('about');
        
            $table->string('email');
            
            // Assuming 'instagram' and 'contact_number' are URLs or longer strings
            // Change them to text or a suitable data type based on your needs
            $table->text('instagram');
            $table->text('contact_number');
            $table->timestamps();
        
        });        
    }
 
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clubs');
    }
};
