<?php

namespace Database\Seeders;

use App\Models\Tag;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Role::create(['name' => 'developer']);
        Role::create(['name' => 'admin']);
        Role::create(['name' => 'customer']);

        Tag::create(
            [
                'name' => 'facebook',
                'type' => 'social_media'
            ]
        );
        Tag::create(
            [
                'name' => 'youtube',
                'type' => 'social_media'
            ]
        );
        Tag::create(
            [
                'name' => 'twitter',
                'type' => 'social_media'
            ]
        );

        $user=User::create(
            [
                'first_name'=>'pedro',
                'last_name'=>'pedrote',
                'email'=>'pedro@pedro.com',
                'password'=>Hash::make('pedro@pedro.com'),
                'phone'=>'+54777841',
                'photo_default'=>'https://img-9gag-fun.9cache.com/photo/a6EgBr8_460swp.webp',
                'birth_date'=>Carbon::now()
            ]
        );

        $user->SocialMediaSubscription()->createMany(
            [
                ['tag_id'=>1,'name'=>'@pedritoCaliente',],
                ['tag_id'=>2,'name'=>'@pedritoFrio',],
                ['tag_id'=>3,'name'=>'@pedritoMedio',]
            ]
        );

        $user->address()->create
        (
            [
            'state_id'=>2,
            'adress'=>'long shore',
            'city'=>'felicity city',
            'latitude'=>002,
            'longitude'=>000.3333,
            'background_color'=>'black',
            'main_color'=>'white',
            'secondary_color'=>'blue',
            'text_one_color'=>'yellow',
            'text_two_color'=>'purple',
            'logo_white'=>'https://img-9gag-fun.9cache.com/photo/aqjMx4Q_460swp.webp',
            'active'=>true,
            ]
        );
    }
} 
