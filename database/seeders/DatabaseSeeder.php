<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\Bank;
use App\Models\City;
use App\Models\Company;
use App\Models\Role;
use App\Models\Seat;
use App\Models\Ticket;
use App\Models\Travel;
use Database\Factories\CityFactory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        City::factory()->create(['name' => 'Addis Ababa']);
        City::factory()->create(['name' => 'Jimma']);
        City::factory()->create(['name' => 'Gonder']);
        City::factory()->create(['name' => 'Harrar']);
        City::factory()->create(['name' => 'Tigray']);

        Company::factory()->create(['name' => 'Selam Bus']);
        Company::factory()->create(['name' => 'Geda Bus']);

        Travel::factory()->create(['startCityId'=>1, 'dropOfCityId' => 2]);
        Travel::factory()->create(['startCityId'=>2, 'dropOfCityId' => 5]);
        Travel::factory()->create(['startCityId'=>2, 'dropOfCityId' => 3]);
        Travel::factory()->create(['startCityId'=>1, 'dropOfCityId' => 2]);
        Travel::factory()->create(['startCityId'=>1, 'dropOfCityId' => 3]);
        Travel::factory()->create(['startCityId'=>1, 'dropOfCityId' => 4]);
        Travel::factory()->create(['startCityId'=>1, 'dropOfCityId' => 5]);

        //Ticket::factory()->create();
        // Seat::factory(20)->create();


        Bank::factory()->create(['name'=>'Commercial Bank','bank_logo'=>'https://res.cloudinary.com/jethenk/image/upload/v1605531551/download_llfsgj.jpg']);
        Bank::factory()->create(['name'=>'Dashen Bank','bank_logo'=>'https://res.cloudinary.com/jethenk/image/upload/v1605532106/download_1_lcwyfw.png']);
        Bank::factory()->create(['name'=>'Zemen Bank','bank_logo'=>'https://res.cloudinary.com/jethenk/image/upload/v1605531533/download_hbuevj.png']);

       Role::factory()->create(['name'=>'checker']);
       Role::factory()->create(['name'=>'finance']);
       Role::factory()->create(['name'=>'dispatcher']);
       Role::factory()->create(['name'=>'admin']);


        //Admin table

        $admin = new Admin();
        $admin->id = 1;
        $admin->email = "systemOwner@systemOwner.com";
        $admin->type = "booking_company";
        $admin->password = Hash::make("password");
        $admin->role_id = 4;
        $admin->save();

        $admin = new Admin();
        $admin->company_id = 1;
        $admin->email = "admin@selamBus.com";
        $admin->type = "company";
        $admin->password = Hash::make("password");
        $admin->role_id = 4;
        $admin->save();

        $admin = new Admin();
        $admin->company_id = 1;
        $admin->email = "checker@selamBus.com";
        $admin->type = "company";
        $admin->password = Hash::make("password");
        $admin->role_id = 1;
        $admin->save();
    }
}
