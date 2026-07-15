<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('barang_gadai', function (Blueprint $table) {
            $table->date('tanggal_jatuh_tempo')->nullable()->index();
        });

        DB::table('barang_gadai')->orderBy('id')->chunkById(100, function ($rows) {
            foreach ($rows as $row) {
                DB::table('barang_gadai')->where('id', $row->id)->update([
                    'tanggal_jatuh_tempo' => Carbon::parse($row->tanggal_gadai)->addDays($row->jangka_waktu)->toDateString(),
                ]);
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('barang_gadai', function (Blueprint $table) {
            $table->dropColumn('tanggal_jatuh_tempo');
        });
    }
};
