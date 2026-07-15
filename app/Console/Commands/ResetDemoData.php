<?php

namespace App\Console\Commands;

use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;
use App\Models\BarangGadai;
use Database\Seeders\BarangGadaiSeeder;

#[Signature('demo:reset')]
#[Description('Reset demo data for BarangGadai')]
class ResetDemoData extends Command
{
    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Truncating BarangGadai table...');
        BarangGadai::truncate();

        $this->info('Seeding BarangGadai data...');
        $this->call(BarangGadaiSeeder::class);

        $this->info('Demo data reset successfully.');
    }
}
