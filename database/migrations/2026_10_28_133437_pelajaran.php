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
        Schema::create('pelajaran', function (Blueprint $table) {
            $table->uuid("id")->primary();
            $table->string("namaPelajaran")->unique();
            $table->string("kodePelajaran");
            
            // relasi, satu user bisa memiliki banyak pelajaran
            $table->foreignUuid('usersId')->nullable()->constrained('users')->cascadeOnDelete();
            
            $table->timestamps();

            $table->unique(["namaPelajaran", "usersId"]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
