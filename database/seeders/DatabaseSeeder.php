<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\Company;
use App\Models\Role;
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
        $role = new Role();
        $role->id = 1;
        $role->name = "superadmin";
        $role->save();
              //***Admin role
        $role = new Role();
        $role->id = 2;
        $role->name = "admin";
        $role->save();

        //Admin table

        $admin = new Admin();
        $admin->id = 1;
        $admin->company_id = 1;
        $admin->userName = "systemOwner";
        $admin->password = Hash::make("systemowner");
        $admin->role_id = 1;
        $admin->save();



    }
}
