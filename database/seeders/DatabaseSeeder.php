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
        // \App\Models\User::factory(10)->create();

        //system owner the campany owner
        $systemOwner = new Company();
        $systemOwner->id =1;
        $systemOwner->name ="system owner";
        $systemOwner->save();

        //role
                //***superAdmin role


        $city = new City();
        $city->name = "Addis Ababa";
        $city->save();

        Company::factory(5)->create();
        City::factory(10)->create();
        Travel::factory(10)->create();
        //Ticket::factory()->create();
        Seat::factory(20)->create();


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
        //$admin->company_id = 1;
        $admin->email = "systemOwner@systemOwner.com";
        $admin->type = "systemOwner";
        $admin->password = Hash::make("systemowner");
        $admin->role_id = 4;
        $admin->save();

        $admin = new Admin();
        $admin->company_id = 1;
        $admin->email = "checker@checker.com";
        $admin->type = "company";
        $admin->password = Hash::make("checker");
        $admin->role_id = 1;
        $admin->save();
    }
}
