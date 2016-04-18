<?php

use Illuminate\Database\Seeder;
use App\Models\Account;

class AccountTableSeeder extends Seeder {

  public function run()
  {
    DB::table('accounts')->delete();

    for ($i=0; $i < 2; $i++) {
      Account::create([
        'account'   => 'eventAccount'.$i,
        'password'    => '12345678',
        'name'    => 'name'.$i,
        'nationality' => 'France',
        'city' => 'Paris',
        'gender' => 'male',
        'address' => 'asdfghjkl',
        'headImg' => '',
        'nickName' => 'nickName',
      ]);
    }
  }

}