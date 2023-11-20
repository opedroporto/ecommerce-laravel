<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

use App\Models;

class AdminUsuarioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // \DB::unprepared(
        //     file_get_contents(__DIR__ . '/fran.sql')
        // );
        
        // DB::table('usuarios')->where('id', 1)->update(array(
        //     'senha' => bcrypt(env("ADMIN_PASSWORD")),
        // ));
    }
}
