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
        Schema::table('comments', function (Blueprint $table) {
            // Hapus foreign key dan kolom user_id
            $table->dropForeign(['user_id']);
            $table->dropColumn('user_id');

            // Tambahkan admin_id sebagai foreign key ke tabel admins
            $table->foreignId('admin_id')->constrained('admins');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('comments', function (Blueprint $table) {
            // Hapus foreign key dan kolom admin_id
            $table->dropForeign(['admin_id']);
            $table->dropColumn('admin_id');

            // Tambahkan kembali user_id
            $table->foreignId('user_id')->constrained('users');
        });
    }
};

