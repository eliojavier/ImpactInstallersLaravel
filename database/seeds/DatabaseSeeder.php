<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->cleanDatabase();
        factory('App\User', 5)->create();
        factory('App\Location', 10)->create();
//        factory('App\Assignment', 50)->create();
//        factory('App\Bill', 50)->create();
//        factory('App\Detail', 300)->create();
//         $this->call(UsersTableSeeder::class);
    }

    public function cleanDatabase()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        foreach ($this->tables as $tableName) {
            DB::table($tableName)->truncate();
        }
        DB::statement('SET FOREIGN_KEY_CHECKS=1');
    }

    private $tables = [
        'users',
        'locations',
        'assignments',
        'bills',
        'details'
    ];
}
