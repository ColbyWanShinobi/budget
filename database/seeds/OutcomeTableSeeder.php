<?php

use Illuminate\Database\Seeder;

class OutcomeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->runEnvelope1();
        $this->runEnvelope2();
        $this->runEnvelope3();
        $this->runEnvelope4();
        $this->runEnvelope5();
        $this->runEnvelope6();
        $this->runEnvelope7();
        $this->runEnvelope8();
        $this->runEnvelope9();
        $this->runEnvelope10();
        $this->runEnvelope11();
        $this->runEnvelope12();
        $this->runEnvelope13();
    }

    /**
     * Run the database seed for envelope "Logement" on account "Compte joint".
     *
     * @return void
     */
    public function runEnvelope1() {
        DB::table('outcomes')->insert([
            'envelope_id' => 1,
            'name' => "Loyer",
            'amount' => 700,
            'date' => mktime(0, 0, 0, 7, 6, 2015),
            'effective' => 1,
        ]);
        EventTableSeeder::seedFromEntity('outcome');

        DB::table('outcomes')->insert([
            'envelope_id' => 1,
            'name' => "Assurance habitation",
            'amount' => 25.66,
            'date' => mktime(0, 0, 0, 7, 6, 2015),
            'effective' => 1,
        ]);
        EventTableSeeder::seedFromEntity('outcome');
    }

    /**
     * Run the database seed for envelope "Transport" on account "Compte joint".
     *
     * @return void
     */
    public function runEnvelope2() {
        DB::table('outcomes')->insert([
            'envelope_id' => 2,
            'name' => "Essence",
            'amount' => 55.47,
            'date' => mktime(0, 0, 0, 7, 1, 2015),
            'effective' => 1,
        ]);
        EventTableSeeder::seedFromEntity('outcome');

        DB::table('outcomes')->insert([
            'envelope_id' => 2,
            'name' => "Train (Lille - Le Quesnoy)",
            'amount' => 3.20,
            'date' => mktime(0, 0, 0, 7, 2, 2015),
            'effective' => 1,
        ]);
        EventTableSeeder::seedFromEntity('outcome');

        DB::table('outcomes')->insert([
            'envelope_id' => 2,
            'name' => "Essence",
            'amount' => 15.02,
            'date' => mktime(0, 0, 0, 7, 6, 2015),
            'effective' => 1,
        ]);
        EventTableSeeder::seedFromEntity('outcome');

        DB::table('outcomes')->insert([
            'envelope_id' => 2,
            'name' => "Assurance voiture",
            'amount' => 25.66,
            'date' => mktime(0, 0, 0, 7, 6, 2015),
            'effective' => 1,
        ]);
        EventTableSeeder::seedFromEntity('outcome');

        DB::table('outcomes')->insert([
            'envelope_id' => 2,
            'name' => "Abonnement Transpole Simon",
            'amount' => 28,
            'date' => mktime(0, 0, 0, 7, 7, 2015),
            'effective' => 1,
        ]);
        EventTableSeeder::seedFromEntity('outcome');

        DB::table('outcomes')->insert([
            'envelope_id' => 2,
            'name' => "Train (Lille - Templeuve)",
            'amount' => 1.20,
            'date' => mktime(0, 0, 0, 7, 7, 2015),
            'effective' => 1,
        ]);
        EventTableSeeder::seedFromEntity('outcome');

        DB::table('outcomes')->insert([
            'envelope_id' => 2,
            'name' => "Train (Lille - Templeuve)",
            'amount' => 1.20,
            'date' => mktime(0, 0, 0, 7, 7, 2015),
            'effective' => 1,
        ]);
        EventTableSeeder::seedFromEntity('outcome');

        DB::table('outcomes')->insert([
            'envelope_id' => 2,
            'name' => "Essence",
            'amount' => 55.96,
            'date' => mktime(0, 0, 0, 7, 17, 2015),
            'effective' => 1,
        ]);
        EventTableSeeder::seedFromEntity('outcome');
    }

    /**
     * Run the database seed for envelope "Nourriture" on account "Compte joint".
     *
     * @return void
     */
    public function runEnvelope3() {
        DB::table('outcomes')->insert([
            'envelope_id' => 3,
            'name' => "Harmonie nature",
            'amount' => 16.60,
            'date' => mktime(0, 0, 0, 7, 1, 2015),
            'effective' => 1,
        ]);
        EventTableSeeder::seedFromEntity('outcome');

        DB::table('outcomes')->insert([
            'envelope_id' => 3,
            'name' => "Carrefour",
            'amount' => 24.76,
            'date' => mktime(0, 0, 0, 7, 1, 2015),
            'effective' => 1,
        ]);
        EventTableSeeder::seedFromEntity('outcome');

        DB::table('outcomes')->insert([
            'envelope_id' => 3,
            'name' => "Carrefour",
            'amount' => 41.89,
            'date' => mktime(0, 0, 0, 7, 1, 2015),
            'effective' => 1,
        ]);
        EventTableSeeder::seedFromEntity('outcome');

        DB::table('outcomes')->insert([
            'envelope_id' => 3,
            'name' => "Carrefour",
            'amount' => 55.82,
            'date' => mktime(0, 0, 0, 7, 1, 2015),
            'effective' => 1,
        ]);
        EventTableSeeder::seedFromEntity('outcome');

        DB::table('outcomes')->insert([
            'envelope_id' => 3,
            'name' => "Ferme Delemotte",
            'amount' => 6.50,
            'date' => mktime(0, 0, 0, 7, 6, 2015),
            'effective' => 1,
        ]);
        EventTableSeeder::seedFromEntity('outcome');

        DB::table('outcomes')->insert([
            'envelope_id' => 3,
            'name' => "Biocoop",
            'amount' => 18.12,
            'date' => mktime(0, 0, 0, 7, 6, 2015),
            'effective' => 1,
        ]);
        EventTableSeeder::seedFromEntity('outcome');

        DB::table('outcomes')->insert([
            'envelope_id' => 3,
            'name' => "Sandwich Imaginarium",
            'amount' => 3.5,
            'date' => mktime(0, 0, 0, 7, 7, 2015),
            'effective' => 1,
        ]);
        EventTableSeeder::seedFromEntity('outcome');

        DB::table('outcomes')->insert([
            'envelope_id' => 3,
            'name' => "Carrefour",
            'amount' => 7.44,
            'date' => mktime(0, 0, 0, 7, 10, 2015),
            'effective' => 1,
        ]);
        EventTableSeeder::seedFromEntity('outcome');

        DB::table('outcomes')->insert([
            'envelope_id' => 3,
            'name' => "Ferme Delemotte",
            'amount' => 12.40,
            'date' => mktime(0, 0, 0, 7, 13, 2015),
            'effective' => 1,
        ]);
        EventTableSeeder::seedFromEntity('outcome');

        DB::table('outcomes')->insert([
            'envelope_id' => 3,
            'name' => "Biocoop",
            'amount' => 19.55,
            'date' => mktime(0, 0, 0, 7, 13, 2015),
            'effective' => 1,
        ]);
        EventTableSeeder::seedFromEntity('outcome');

        DB::table('outcomes')->insert([
            'envelope_id' => 3,
            'name' => "Carrefour",
            'amount' => 38.06,
            'date' => mktime(0, 0, 0, 7, 13, 2015),
            'effective' => 1,
        ]);
        EventTableSeeder::seedFromEntity('outcome');

        DB::table('outcomes')->insert([
            'envelope_id' => 3,
            'name' => "Ferme Delemotte",
            'amount' => 19.85,
            'date' => mktime(0, 0, 0, 7, 17, 2015),
            'effective' => 1,
        ]);
        EventTableSeeder::seedFromEntity('outcome');

        DB::table('outcomes')->insert([
            'envelope_id' => 3,
            'name' => "Label Vie",
            'amount' => 93.91,
            'date' => mktime(0, 0, 0, 7, 17, 2015),
            'effective' => 1,
        ]);
        EventTableSeeder::seedFromEntity('outcome');
    }

    /**
     * Run the database seed for envelope "Soins & santé" on account "Compte joint".
     *
     * @return void
     */
    public function runEnvelope4() {
        DB::table('outcomes')->insert([
            'envelope_id' => 3,
            'name' => "Mutuelle Simon & Élie",
            'amount' => 65.91,
            'date' => mktime(0, 0, 0, 7, 6, 2015),
            'effective' => 1,
        ]);
        EventTableSeeder::seedFromEntity('outcome');

        DB::table('outcomes')->insert([
            'envelope_id' => 3,
            'name' => "Mutuelle Delphine",
            'amount' => 51.31,
            'date' => mktime(0, 0, 0, 7, 6, 2015),
            'effective' => 1,
        ]);
        EventTableSeeder::seedFromEntity('outcome');

        DB::table('outcomes')->insert([
            'envelope_id' => 3,
            'name' => "Reflet du Soleil",
            'amount' => 61,
            'date' => mktime(0, 0, 0, 7, 7, 2015),
            'effective' => 1,
        ]);
        EventTableSeeder::seedFromEntity('outcome');

        DB::table('outcomes')->insert([
            'envelope_id' => 3,
            'name' => "Body Nature",
            'amount' => 19.95,
            'date' => mktime(0, 0, 0, 7, 9, 2015),
            'effective' => 1,
        ]);
        EventTableSeeder::seedFromEntity('outcome');

        DB::table('outcomes')->insert([
            'envelope_id' => 3,
            'name' => "Coiffeur Arc-en-Ciel",
            'amount' => 39.50,
            'date' => mktime(0, 0, 0, 7, 9, 2015),
            'effective' => 1,
        ]);
        EventTableSeeder::seedFromEntity('outcome');
    }

    /**
     * Run the database seed for envelope "Vêtements" on account "Compte joint".
     *
     * @return void
     */
    public function runEnvelope5() {

    }

    /**
     * Run the database seed for envelope "Culture & Loisirs" on account "Compte joint".
     *
     * @return void
     */
    public function runEnvelope6() {
        DB::table('outcomes')->insert([
            'envelope_id' => 6,
            'name' => "Free Mobile",
            'amount' => 2,
            'date' => mktime(0, 0, 0, 7, 7, 2015),
            'effective' => 1,
        ]);
        EventTableSeeder::seedFromEntity('outcome');
    }

    /**
     * Run the database seed for envelope "Cadeaux" on account "Compte joint".
     *
     * @return void
     */
    public function runEnvelope7() {
        DB::table('outcomes')->insert([
            'envelope_id' => 7,
            'name' => "Anniversaire Odile",
            'amount' => 12,
            'date' => mktime(0, 0, 0, 7, 2, 2015),
            'effective' => 1,
        ]);
        EventTableSeeder::seedFromEntity('outcome');

        DB::table('outcomes')->insert([
            'envelope_id' => 7,
            'name' => "Anniversaire Marie-Agnès",
            'amount' => 10,
            'date' => mktime(0, 0, 0, 7, 9, 2015),
            'effective' => 1,
        ]);
        EventTableSeeder::seedFromEntity('outcome');
    }

    /**
     * Run the database seed for envelope "Vacances" on account "Compte joint".
     *
     * @return void
     */
    public function runEnvelope8() {
        DB::table('outcomes')->insert([
            'envelope_id' => 8,
            'name' => "Weekend à Hurdegaryp - Airbnb",
            'amount' => 137,
            'date' => mktime(0, 0, 0, 7, 7, 2015),
            'effective' => 1,
        ]);
        EventTableSeeder::seedFromEntity('outcome');

        DB::table('outcomes')->insert([
            'envelope_id' => 8,
            'name' => "Weekend à Hurdegaryp - Essence",
            'amount' => 30.33,
            'date' => mktime(0, 0, 0, 7, 13, 2015),
            'effective' => 1,
        ]);
        EventTableSeeder::seedFromEntity('outcome');

        DB::table('outcomes')->insert([
            'envelope_id' => 8,
            'name' => "Weekend à Hurdegaryp - Nourriture",
            'amount' => 52.19,
            'date' => mktime(0, 0, 0, 7, 13, 2015),
            'effective' => 1,
        ]);
        EventTableSeeder::seedFromEntity('outcome');

        DB::table('outcomes')->insert([
            'envelope_id' => 8,
            'name' => "Weekend à Hurdegaryp - Culture & Loisirs",
            'amount' => 60,
            'date' => mktime(0, 0, 0, 7, 15, 2015),
            'effective' => 1,
        ]);
        EventTableSeeder::seedFromEntity('outcome');

        DB::table('outcomes')->insert([
            'envelope_id' => 8,
            'name' => "Weekend à Hurdegaryp - Nourriture",
            'amount' => 22.53,
            'date' => mktime(0, 0, 0, 7, 16, 2015),
            'effective' => 1,
        ]);
        EventTableSeeder::seedFromEntity('outcome');

        DB::table('outcomes')->insert([
            'envelope_id' => 8,
            'name' => "Weekend à Hurdegaryp - Nourriture",
            'amount' => 30,
            'date' => mktime(0, 0, 0, 7, 16, 2015),
            'effective' => 1,
        ]);
        EventTableSeeder::seedFromEntity('outcome');

        DB::table('outcomes')->insert([
            'envelope_id' => 8,
            'name' => "Weekend à Hurdegaryp - Essence",
            'amount' => 30.01,
            'date' => mktime(0, 0, 0, 7, 16, 2015),
            'effective' => 1,
        ]);
        EventTableSeeder::seedFromEntity('outcome');
    }

    /**
     * Run the database seed for envelope "Épargne" on account "Compte joint".
     *
     * @return void
     */
    public function runEnvelope9() {
        DB::table('outcomes')->insert([
            'envelope_id' => 9,
            'name' => "Virement vers le CEL",
            'amount' => 1000,
            'date' => mktime(0, 0, 0, 7, 3, 2015),
            'effective' => 1,
        ]);
        EventTableSeeder::seedFromEntity('outcome');

        DB::table('outcomes')->insert([
            'envelope_id' => 9,
            'name' => "Virement Livret Agir",
            'amount' => 10,
            'date' => mktime(0, 0, 0, 7, 15, 2015),
            'effective' => 1,
        ]);
        EventTableSeeder::seedFromEntity('outcome');

        DB::table('outcomes')->insert([
            'envelope_id' => 9,
            'name' => "Virement PEL",
            'amount' => 45,
            'date' => mktime(0, 0, 0, 7, 15, 2015),
            'effective' => 1,
        ]);
        EventTableSeeder::seedFromEntity('outcome');
    }

    /**
     * Run the database seed for envelope "Logement" on account "Vacances en Écosse".
     *
     * @return void
     */
    public function runEnvelope10() {
        DB::table('outcomes')->insert([
            'envelope_id' => 10,
            'name' => "Bed & Breakfast Edimburg",
            'amount' => 150,
            'date' => mktime(0, 0, 0, 10, 1, 2015),
            'effective' => 0,
        ]);
        EventTableSeeder::seedFromEntity('outcome');

        DB::table('outcomes')->insert([
            'envelope_id' => 10,
            'name' => "Bed & Breakfast Dufftown",
            'amount' => 150,
            'date' => mktime(0, 0, 0, 10, 1, 2015),
            'effective' => 0,
        ]);
        EventTableSeeder::seedFromEntity('outcome');

        DB::table('outcomes')->insert([
            'envelope_id' => 10,
            'name' => "Bed & Breakfast Wick",
            'amount' => 150,
            'date' => mktime(0, 0, 0, 10, 1, 2015),
            'effective' => 0,
        ]);
        EventTableSeeder::seedFromEntity('outcome');

        DB::table('outcomes')->insert([
            'envelope_id' => 10,
            'name' => "Bed & Breakfast Ullapool",
            'amount' => 150,
            'date' => mktime(0, 0, 0, 10, 1, 2015),
            'effective' => 0,
        ]);
        EventTableSeeder::seedFromEntity('outcome');

        DB::table('outcomes')->insert([
            'envelope_id' => 10,
            'name' => "Bed & Breakfast Arrochar",
            'amount' => 150,
            'date' => mktime(0, 0, 0, 10, 1, 2015),
            'effective' => 0,
        ]);
        EventTableSeeder::seedFromEntity('outcome');
    }

    /**
     * Run the database seed for envelope "Transport" on account "Vacances en Écosse".
     *
     * @return void
     */
    public function runEnvelope11() {
        DB::table('outcomes')->insert([
            'envelope_id' => 10,
            'name' => "Shuttle",
            'amount' => 100,
            'date' => mktime(0, 0, 0, 10, 1, 2015),
            'effective' => 0,
        ]);
        EventTableSeeder::seedFromEntity('outcome');

        DB::table('outcomes')->insert([
            'envelope_id' => 10,
            'name' => "Essence",
            'amount' => 100,
            'date' => mktime(0, 0, 0, 10, 1, 2015),
            'effective' => 0,
        ]);
        EventTableSeeder::seedFromEntity('outcome');
    }

    /**
     * Run the database seed for envelope "Nourriture" on account "Vacances en Écosse".
     *
     * @return void
     */
    public function runEnvelope12() {
        DB::table('outcomes')->insert([
            'envelope_id' => 10,
            'name' => "Repas",
            'amount' => 300,
            'date' => mktime(0, 0, 0, 10, 1, 2015),
            'effective' => 0,
        ]);
        EventTableSeeder::seedFromEntity('outcome');
    }

    /**
     * Run the database seed for envelope "Sorties" on account "Vacances en Écosse".
     *
     * @return void
     */
    public function runEnvelope13() {
        DB::table('outcomes')->insert([
            'envelope_id' => 10,
            'name' => "Museum of Childhood",
            'amount' => 15,
            'date' => mktime(0, 0, 0, 10, 1, 2015),
            'effective' => 0,
        ]);
        EventTableSeeder::seedFromEntity('outcome');

        DB::table('outcomes')->insert([
            'envelope_id' => 10,
            'name' => "Bateau Loch Lomond",
            'amount' => 30,
            'date' => mktime(0, 0, 0, 10, 1, 2015),
            'effective' => 0,
        ]);
        EventTableSeeder::seedFromEntity('outcome');

        DB::table('outcomes')->insert([
            'envelope_id' => 10,
            'name' => "Château d'Inveraray",
            'amount' => 20,
            'date' => mktime(0, 0, 0, 10, 1, 2015),
            'effective' => 0,
        ]);
        EventTableSeeder::seedFromEntity('outcome');
    }

}
