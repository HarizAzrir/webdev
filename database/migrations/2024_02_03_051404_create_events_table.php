<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->string('eventName');
            $table->date('dateStart');
            $table->date('dateEnd');
            $table->time('timeStart');
            $table->time('timeEnd');
            $table->string('venue');
            $table->string('description');
            $table->decimal('price', 5, 2);
            $table->string('category');
            $table->string('subcategory1');
            $table->string('status');
            $table->string('image');
            $table->foreignId('club_id')->constrained('clubs');
            // $table->timestamps(); // Uncomment if you want timestamps
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('events');

        Schema::table('events', function (Blueprint $table) {
            $table->dropForeign(['club_id']);
            $table->dropColumn('club_id');
        });
        
    }
};
