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
        Schema::table('candidates', function(Blueprint $table){
            $table->dropColumn('status');
            $table->integer('situation')->default(1);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('candidates', function(Blueprint $table){
            $table->integer('status')->default(1);
            $table->dropColumn('situation');
        });
    }
};
