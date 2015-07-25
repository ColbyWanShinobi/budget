<?php

use App\Revenue;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class RevenueTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->runAccount1();
        $this->runAccount2();
    }

    /**
     * Run the database seed for account "Compte joint".
     *
     * @return void
     */
    public function runAccount1()
    {
        Revenue::create([
            'account_id' => 1,
            'name' => 'Salaire Simon',
            'amount' => 1551.24,
            'date' => Carbon::create(2015, 7, 2, 0),
        ]);

        Revenue::create([
            'account_id' => 1,
            'name' => 'Indemnité Delphine',
            'amount' => 1108.20,
            'date' => Carbon::create(2015, 7, 1, 0),
        ]);

        Revenue::create([
            'account_id' => 1,
            'name' => 'Prestations CAF',
            'amount' => 446.10,
            'date' => Carbon::create(2015, 7, 6, 0),
        ]);
    }

    /**
     * Run the database seed for account "Vacances en Écosse".
     *
     * @return void
     */
    public function runAccount2()
    {
        Revenue::create([
            'account_id' => 2,
            'name' => 'Enveloppe vacances',
            'amount' => 600,
            'date' => Carbon::create(2015, 10, 1, 0),
        ]);

        Revenue::create([
            'account_id' => 2,
            'name' => 'Enveloppe nourriture',
            'amount' => 200,
            'date' => Carbon::create(2015, 10, 1, 0),
        ]);
    }
}
