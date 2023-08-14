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
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('title', 80);
            $table->unsignedBigInteger('company_id');
            $table->text('description');
            $table->string('job_reference', 10)->unique();
        });

        Schema::table('projects', function (Blueprint $table){
            $table->foreign('company_id')->references('id')->on('companies');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {   

        Schema::table('projects', function(Blueprint $table){
            $table->dropForeign('projects_company_id_foreign');
            $table->dropColumn('company_id');
        });

        Schema::dropIfExists('projects');
    }
};
