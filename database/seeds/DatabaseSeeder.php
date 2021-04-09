<?php
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call('UserTableSeeder');
    }
}

class UserTableSeeder extends Seeder
{   
    public function run()
    {
        DB::table('users')->insert([
            ['name'=>'Quốc Việt','slug'=>'quoc-viet','phone'=>'0905999394','email'=>'lqviet.it@gmail.com','sex'=>'Nam','password'=>Hash::make('0932599440qv'), 'level'=>'admin'],
        ]);
       /* DB::table('options')->insert([
        	['title'=>'5 Ship', 'phone'=>'0905999394','email'=>'lqviet.it@gmail.com', 'address'=>'06 Trịnh Đình Trọng - HCM', 'copyright'=>'Developworld'],
        ]);*/
    }
}
