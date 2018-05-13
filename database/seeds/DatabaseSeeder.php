<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $inserts = factory(App\Models\Person::class)->times(200)->create();

        \DB::statement(" insert INTO user_persons (user_id,person_id,
        parent_person_id,created_at,updated_at) VALUES (1, 1, null, now(), now());");
        \DB::statement(" iNSERT into user_persons (user_id,person_id,
        parent_person_id,created_at, updated_at) select 1, p.id, 1, now(), now()
         from persons p where p.id not in (1);");
        \DB::statement(" DROP TABLE IF EXISTS meses;");
        \DB::statement("  create TABLE meses ( id int(11) NOT NULL AUTO_INCREMENT,
          month int(11) DEFAULT NULL, date_to varchar(6) DEFAULT NULL,
          PRIMARY KEY (id) ) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;");
        \DB::statement(" iNSERT INTO meses VALUES (1,1,'-01-31'),(2,2,'-02-28'),
        (3,3,'-03-31'),(4,4,'-04-30'),(5,5,'-05-31'),(6,6,'-06-30'),
        (7,7,'-07-31'),(8,8,'-08-31'),(9,9,'-09-30'),(10,10,'-10-31'),
        (11,11,'-11-30'),(12,12,'-12-31');");
        \DB::statement(" insert Into periods (code, year, period_number,
         date_from, date_to, person_id) select concat('2018','-',m.month),
          2018, m.month, concat('2018','-',m.month,'-01'), concat('2018',
          m.date_to), p.id from persons p, meses m order by 2,3;");
        \DB::statement(" Insert into person_zones (sifere_coef,iibb_aliquot,
        zone_id,created_at, updated_at,person_id)
         select 0.6, 3, z.id, now(), now(), p.id
        from persons p join zones z on z.id in ( 22,23) where p.id in (1);");
        \DB::statement(" inSERT Into person_configurations (person_id,
         created_at, updated_at) select id, now(), now() from persons; ");

          /*
          insert into periods (code, year, period_number, date_from, date_to, person_id)
          select concat('2017','-',m.month), 2017, m.month, concat('2017','-',m.month,'-01')
          , concat('2017',m.date_to), p.id
          from persons p, meses m order by 2,3;

          INSERT INTO period_liquidations
          (apply_to,period_id,person_id,status,created_at,updated_at)
          SELECT  'iibb', id, 1, 1, now(), now()
           FROM larzaba3_finance.periods;*/

        //$inserts = factory(App\Models\Receipt::class)->times(200)->create();


    }
}
