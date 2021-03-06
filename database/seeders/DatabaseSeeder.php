<?php

namespace Database\Seeders;

use App\Models\Address;
use App\Models\Field;
use App\Models\Onfarm;
use App\Models\Planting;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Artisan;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        $this->call(
            UserSeeder::class
        );
        \App\Models\Organization::factory(20)->hasAttached(
            User::factory(5)->has(
                Field::factory()->has(Address::factory())
                    ->has(
                        Planting::factory()->has(
                            Onfarm::factory(3)
                        )
                    )
            )
        )->has(Address::factory())->create();
        Artisan::call('addresses:import');
    }
}
