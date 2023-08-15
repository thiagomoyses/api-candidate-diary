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
        //alter candidates
        Schema::table('candidates', function (Blueprint $table) {
            $table->string('client_id_fk', 14);
            $table->foreign('client_id_fk')->references('client_id')->on('users');
        });

        //alter companies
        Schema::table('companies', function (Blueprint $table) {
            $table->string('client_id_fk', 14);
            $table->foreign('client_id_fk')->references('client_id')->on('users');
        });

        //alter diary
        Schema::table('diary', function (Blueprint $table) {
            $table->string('client_id_fk', 14);
            $table->foreign('client_id_fk')->references('client_id')->on('users');
        });

        //alter projects
        Schema::table('projects', function (Blueprint $table) {
            $table->string('client_id_fk', 14);
            $table->foreign('client_id_fk')->references('client_id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //alter candidates
        Schema::table('candidates', function (Blueprint $table) {
            $table->dropForeign('candidates_client_id_fk_foreign');
            $table->dropColumn('client_id_fk');
        });

        //alter companies
        Schema::table('companies', function (Blueprint $table) {
            $table->dropForeign('companies_client_id_fk_foreign');
            $table->dropColumn('client_id_fk');
        });

        //alter diary
        Schema::table('diary', function (Blueprint $table) {
            $table->dropForeign('diary_client_id_fk_foreign');
            $table->dropColumn('client_id_fk');
        });

        //alter projects
        Schema::table('projects', function (Blueprint $table) {
            $table->dropForeign('projects_client_id_fk_foreign');
            $table->dropColumn('client_id_fk');
        });
    }
};
