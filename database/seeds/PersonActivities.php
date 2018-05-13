<?php

use Illuminate\Database\Seeder;

class PersonActivities extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      \DB::statement(" update persons set activity_id=1 where activity_id is null ");

      \DB::statement(" Insert into person_activities (person_id,activity_id,
      created_at, updated_at) select p.id, a.id, now(), now() 
      from persons p join activities a on a.id=p.activity_id;");
    }
}
