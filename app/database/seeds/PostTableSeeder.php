<?php

class PostTableSeeder extends Seeder{
	public static $table="posts";



	public static function run(){

		self::create([

        [
          'title' => 'heading 1',
          'company_id'=>'2',
          'body' => 'chingiz@gmasdddaidfl.cofdfm',
        ],
        [
          'title' => 'heading 1',
          'company_id'=>'2',
          'body' => 'chingiz@gmasdddaidfl.cofdfm',
        ],
        [
          'title' => 'heading 1',
          'company_id'=>'2',
          'body' => 'chingiz@gmasdddaidfl.cofdfm',
        ],
        [
          'title' => 'heading 1',
          'company_id'=>'2',
          'body' => 'chingiz@gmasdddaidfl.cofdfm',
        ],
        [
          'title' => 'heading 1',
          'company_id'=>'2',
          'body' => 'chingiz@gmasdddaidfl.cofdfm',
        ],
        [
          'title' => 'heading 1',
          'company_id'=>'2',
          'body' => 'chingiz@gmasdddaidfl.cofdfm',
        ],
		    [
          'title' => 'heading 1',
          'company_id'=>'2',
          'body' => 'chingiz@gmasdddaidfl.cofdfm',
      	]
		]);

		return null;


	}


}

PostTableSeeder::run();