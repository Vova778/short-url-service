<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('clicks', function (Blueprint $table) {
            $table->string('browser')->nullable()->after('ip_address');
            $table->string('device')->nullable()->after('browser');
            $table->string('country', 100)->nullable()->after('device');
            $table->text('user_agent')->nullable()->after('country');
        });
    }

    public function down(): void
    {
        Schema::table('clicks', function (Blueprint $table) {
            $table->dropColumn(['browser', 'device', 'country', 'user_agent']);
        });
    }
};
