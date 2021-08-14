<?php

namespace Database\Seeders;

use App\Models\BranchOffice;
use App\Models\Companies;
use App\Models\Currency;
use App\Models\Image;
use App\Models\Product;
use App\Models\ProductDetail;
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

        Tag::create(['name' => 'facebook','type' => 'social_media']);        
        Tag::create(['name' => 'youtube','type' => 'social_media']);        
        Tag::create(['name' => 'twitter','type' => 'social_media']);

        Tag::create( ['name' => 'photo_default','type' => 'user_image']);

        Tag::create( ['name' => 'logo_white','type' => 'branch_office_image']);

        Tag::create( ['name' => 'background_color','type' => 'branch_office_color']);
        Tag::create( ['name' => 'main_color','type' => 'branch_office_color']);
        Tag::create( ['name' => 'secondary_color','type' => 'branch_office_color']);
        Tag::create( ['name' => 'text_one_color','type' => 'branch_office_color']);
        Tag::create( ['name' => 'text_two_color','type' => 'branch_office_color']);

        Tag::create( ['name' => 'cold sodas','type' => 'product_category']);
        Tag::create( ['name' => 'dairy products','type' => 'product_category']);
        Tag::create( ['name' => 'precooked fiber','type' => 'product_category']);

        Tag::create( ['name' => 'image_set','type' => 'product_image']);

        Tag::create( ['name' => 'united state dollar','type' => 'currency_set']);
        Tag::create( ['name' => 'euro','type' => 'currency_set']);
        Tag::create( ['name' => 'japanese yen','type' => 'currency_set']);

        Tag::create( ['name' => 'cashier','type' => 'office_subscription_status']);
        Tag::create(['name' => 'customer','type' => 'office_subscription_status']);
        Tag::create( ['name' => 'owner','type' => 'office_subscription_status']);
    

        Companies::create(
            [
            'name'=>'Magic',
            ]
        );

    

        $product1=ProductDetail::create(['name'=>'harina pan','description'=>'se come',]);
        $product1->Categories()->attach(13);


        $product2=ProductDetail::create(['name'=>'queso','description'=>'de vaca',]);
        $product1->Categories()->attach(12);


        $product3=ProductDetail::create(['name'=>'pepsi','description'=>'sabroo',]);
        $product1->Categories()->attach(11);


        $office=BranchOffice::create(
            [
            'company_id'=>1,
            'name'=>'Barinison',
            'dni'=>3323233,
            'phone'=>+5288999,
            'email'=>'Rafita@rafita.com',
            'active'=>true,
            ]
        );

        $office->Colors()->create(['name' => 'red','tag_id'=>6]);        
        $office->Colors()->create(['name' => 'blue','tag_id'=>7]);
        $office->Colors()->create(['name' => 'yellow','tag_id'=>8]);
        $office->Colors()->create(['name' => 'pink','tag_id'=>9]);
        $office->Colors()->create(['name' => 'black','tag_id'=>10]);

        $office->Images()->create(['tag_id'=>5,'name'=>'office_pic01','path'=>'https://img-9gag-fun.9cache.com/photo/aqjMx4Q_460swp.webp']);

        $office->ProductDetails()->attach(1,['price'=>240,'show_price'=>true,'available'=>true]);
        $office->ProductDetails()->attach(2,['price'=>41,'show_price'=>true,'available'=>true]);
        $office->ProductDetails()->attach(3,['price'=>940,'show_price'=>false,'available'=>true]);

        $item1=Product::find(1);
        $item1->Images()->create(['name'=>'harina_pan1','path'=>'https://pancorn.com/site/assets/images/products/blanco.png','tag_id'=>14,]);
        $item1->Images()->create(['name'=>'harina_pan2','path'=>'https://www.sigo.com.ve/images/thumbs/0007752_harina-de-maiz-pan-1-k_450.jpeg','tag_id'=>14,]);
        $item1->Images()->create(['name'=>'harina_pan3','path'=>'http://www.pancorn.com/site/assets/images/team.png','tag_id'=>14]);

        $item2=Product::find(2);
        $item2->Images()->create(['name'=>'queso1','path'=>'https://media.istockphoto.com/photos/cheese-on-white-picture-id1127471287?s=612x612','tag_id'=>14,]);
        $item2->Images()->create(['name'=>'queso2','path'=>'https://www.culturesforhealth.com/learn/wp-content/uploads/2016/04/Homemade-Cheddar-Cheese-header_01_5eb10851988c786328caba5bb8448d58.jpg.webp','tag_id'=>14,]);
        $item2->Images()->create(['name'=>'queso3','path'=>'https://sc04.alicdn.com/kf/Ua9ddbc0277b84e37b4395c2dfe5eb40aV.jpg','tag_id'=>14,]);

        $item3=Product::find(3);
        $item3->Images()->create(['name'=>'pepsi1','path'=>'https://brandemia.org/contenido/subidas/2011/03/pepsi-a-traves-de-la-historia-960x640.jpg','tag_id'=>14,]);
        $item3->Images()->create(['name'=>'pepsi2','path'=>'https://lh3.googleusercontent.com/gpHQtGUPiVrQn-X1_XI2fJVmoIiubFZ_M1VlC7XgbF9vY8DLwmRsW__N7sa-mKjmfEO9fnnJVwYl4rmjnBRdZ40QA1qHWIYf1nw','tag_id'=>14]);
        $item3->Images()->create(['name'=>'pepsi3','path'=>'https://ast.wikipedia.org/wiki/Ficheru:Pepsi_logo_2014.svg','tag_id'=>14,]);

        $office->Currency()->create(['value' => 1.2,'tag_id'=>15]);
        $office->Currency()->create(['value' => 2,'tag_id'=>16]);
        $office->Currency()->create(['value' => 0.3,'tag_id'=>17]);        

        $office->Address()->create
        (
            [
            'state_id'=>3,
            'adress'=>'street Sesame',
            'city'=>'orlun',
            'latitude'=>002444,
            'longitude'=>000.9333,
            'active'=>true,
            ]
        );

        $user=User::create(
            [
                'first_name'=>'pedro',
                'last_name'=>'pedrote',
                'email'=>'pedro@pedro.com',
                'password'=>Hash::make('pedro@pedro.com'),
                'phone'=>'+54777841',
                'birth_date'=>Carbon::now()
            ]
        );

        $user->assignRole('developer');

        $user->Images()->create(['name'=>'user_pic01','path'=>'https://img-9gag-fun.9cache.com/photo/a6EgBr8_460swp.webp','tag_id'=>4,]);     

        $user->Address()->create
        (
            [
            'state_id'=>2,
            'adress'=>'long shore',
            'city'=>'felicity city',
            'latitude'=>002,
            'longitude'=>000.3333,
            'active'=>true,
            ]
        );

       $officeSubscription= $user->OfficeSubscriptions()->create(['branch_office_id'=>1,'user_id'=>1,]);

       $user->SocialMediaSubscription()->create(['tag_id'=>1,'name'=>'@elRafa']);
       $user->SocialMediaSubscription()->create(['tag_id'=>2,'name'=>'@rafa122']);
       $user->SocialMediaSubscription()->create(['tag_id'=>3,'name'=>'@refaBlue']);


        $officeSubscription->StatusLogs()->create(['tag_id'=>1]);
        $officeSubscription->StatusLogs()->create(['tag_id'=>2]);
        $officeSubscription->StatusLogs()->create(['tag_id'=>3]); 

        $officeSubscription->Statuses()->attach(20);        
    }
} 
