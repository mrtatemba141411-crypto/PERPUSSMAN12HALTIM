<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('kunjungans', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('anggota_id')->constrained('anggota')->restrictOnDelete();
            $table->string('tujuan', 100)->default('Kunjungan perpustakaan');
            $table->timestamp('scanned_at')->useCurrent();
            $table->timestamps();
            $table->index('scanned_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kunjungans');
    }
};
