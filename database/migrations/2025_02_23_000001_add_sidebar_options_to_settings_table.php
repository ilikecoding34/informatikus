<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('settings', function (Blueprint $table) {
            $table->string('left_sidebar', 50)->nullable()->after('show_right_column');
            $table->string('right_sidebar', 50)->nullable()->after('left_sidebar');
        });
    }

    public function down(): void
    {
        Schema::table('settings', function (Blueprint $table) {
            $table->dropColumn(['left_sidebar', 'right_sidebar']);
        });
    }
};
