<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('facial_expressions', function (Blueprint $table) {
            // Drop the foreign key constraints first
            $table->dropForeign(['user_id']);
            $table->dropForeign(['test_id']);
            
            // Make both columns required
            $table->foreignId('user_id')->nullable(false)->change();
            $table->foreignId('test_id')->nullable(false)->change();
            
            // Add the foreign key constraints back
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('test_id')->references('id')->on('tests')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::table('facial_expressions', function (Blueprint $table) {
            // Drop the foreign key constraints
            $table->dropForeign(['user_id']);
            $table->dropForeign(['test_id']);
            
            // Make both columns nullable again
            $table->foreignId('user_id')->nullable()->change();
            $table->foreignId('test_id')->nullable()->change();
            
            // Add the foreign key constraints back
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('test_id')->references('id')->on('tests')->onDelete('cascade');
        });
    }
}; 