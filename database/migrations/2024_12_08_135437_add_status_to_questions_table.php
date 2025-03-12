<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('questions', function (Blueprint $table) {
            // Check if the 'status' column does not exist before adding it
            if (!Schema::hasColumn('questions', 'status')) {
                $table->enum('status', ['pending', 'accepted', 'rejected'])->default('pending')->after('description');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('questions', function (Blueprint $table) {
            if (Schema::hasColumn('questions', 'status')) {
                $table->dropColumn('status');
            }
        });
    }
};
