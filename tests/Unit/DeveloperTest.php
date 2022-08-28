<?php

namespace Tests\Unit;

use App\Models\Developer;
use Tests\TestCase;

class DeveloperTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_example()
    {
        $this->assertTrue(true);
    }

    public function test_developers() {
        $response = $this->get('/developers');
        $response->assertStatus(200);
    }

    public function test_developer_duplicate() {
        $developer1 = Developer::create([
            'name' => 'John Doe',
            'email' => 'johndoe@gmail.com'
        ]);

        $developer2 = Developer::create([
            'name' => 'Dary',
            'email' => 'dary@gmail.com'
        ]);

        $this->assertTrue($developer1->name != $developer2->name);
        $this->assertTrue($developer1->email != $developer2->email);

        if( ($developer1->name != $developer2->name) && ($developer1->email != $developer2->email) ) {
            $developer1->delete();
            $developer2->delete();
        }
    }

    public function test_update_developer() {
        $developer = Developer::find(1);
//        $developer->update([
//            'name' => 'Eugene',
//            'email' =>  "eugene@gmail.com"
//        ]);
//        $developer = Developer::factory()->create(); // other attributes from the factory definition

//        $this->putJson("/api/developers/edit/{$developer->id}", ['status' => 'cancelled'])
//            ->assertStatus(200);

        $response = $this->call('PUT', "/developers/update/{$developer->id}", ['name' => 'Eugene', 'email' =>  "eugene@gmail.com"]);

//        $this->assertEquals(true, $response->status());
        $response->assertRedirect('/developers');
    }

    public function test_developer_delete() {
        $developer = Developer::factory()->create();
//        $developer = Developer::first();
        if($developer) {
            $developer->delete();
        }
        $this->assertTrue(true);
    }

    public function test_create_new_developer() {
        $response = $this->post('/developers/create_dev', [
            'name' => 'Jane Doe',
            'email' => 'janedoe@gmail.com',
            'phone' => 1234567895,
            'location' => 'Denver',
            'profile_picture' => 'qqiHOhJsAxePHOJ3ZNPeIE6PwXmg6hlGfNKnoodS.jpg',
            'price_per_hour' => 3,
            'technology' => 'PHP',
            'description' => 'Quaerat alias porro inventore. Accusamus quia voluptatem molestiae dolorum omnis. Qui sequi sit aliquam corrupti quibusdam. Enim cupiditate asperiores est eius labore est.',
            'years_of_experience' => 2,
            'native_language' => 'Bulgarian',
            'linkedin_profile_link' => 'http://www.bradtke.net/harum-dolore-eos-tempore-voluptatum',
        ]);

        $response->assertRedirect('/');
    }

    public function test_database() {
        $this->assertDatabaseHas('developers', [
            'name' => 'John Doe'
        ]);
    }

    public function test_if_seeders_works() {
        $this->seed(); // seed all seeders in the seeders folder
        // Similar:: php artisan db:seed
        $this->assertTrue(true);
    }

    public function test_have_6_users()
    {
        $this->assertGreaterThanOrEqual(6, Developer::count());
    }
}
