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
        Schema::create('diary', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->unsignedBigInteger('candidate_id');
            $table->unsignedBigInteger('company_id');
            $table->string('project_reference', 10);
            $table->integer('status')->default(1);
        
            $table->foreign('candidate_id')->references('id')->on('candidates');
            $table->foreign('company_id')->references('id')->on('companies');
            $table->foreign('project_reference')->references('job_reference')->on('projects');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('diary', function (Blueprint $table) {
            $table->dropForeign(['candidate_id']);
            $table->dropForeign(['project_reference']);
            $table->dropForeign(['company_id']);
        });

        Schema::dropIfExists('diary');
    }
};
