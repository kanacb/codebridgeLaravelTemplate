<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class TemplatesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */

    public function run(): void
    {
        $templates = Storage::json('/resources/templates.json');
        $hasTemplates = DB::select("SELECT * FROM templates");
        if (is_array($templates) && count($hasTemplates) == 0)
            DB::table('templates')->insert($templates);
    }
}
