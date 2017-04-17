<?php

class UserTableSeeder extends Seeder{
	public static $table="users";



	public static function run(){
		self::delete();
		self::create([

		[
          'name' => 'Chingiz',
          'email' => 'chingiz@ssgmasdddsdaisqqddafl.cofdfm',
          'user_type' => 'user',
          'activated' => true,
      	],

      	[
          'name' => 'Chingiz',
          'email' => 'chingiz@sssssgmaissdqqddasdfsadl.cofdm',
          'user_type' => 'user',
          'activated' => true,
      	]
      	,
      	[
          'name' => 'Chingiz',
          'email' => 'chingiz@sgmasddaaasqqdwddsil.csdom',
          'user_type' => 'user',
          'activated' => true,
      	]
      	,
      	[
          'name' => 'Chingiz',
          'email' => 'chingiz@gssssmsfdsasdsdaqqiddl.comad',
          'user_type' => 'user',
          'activated' => true,
      	]
      	,
      	[
          'name' => 'Chingiz',
          'email' => 'chingiz@gsmaassdasdsqqddsdfdil.coam',
          'user_type' => 'user',
          'activated' => true,
      	]

		]);

		return null;


	}


}

UserTableSeeder::run();