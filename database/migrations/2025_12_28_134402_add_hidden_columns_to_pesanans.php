<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('pesanans', function (Blueprint $table) {
            $table->boolean('hidden_by_pembeli')->default(false);
            $table->boolean('hidden_by_penjual')->default(false);
        });
    }

    public function down(): void
    {
        Schema::table('pesanans', function (Blueprint $table) {
            $table->dropColumn([
                'hidden_by_pembeli',
                'hidden_by_penjual'
            ]);
        });
    }
};
