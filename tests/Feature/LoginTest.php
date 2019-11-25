<?php

namespace Tests\Feature;


use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LoginTest extends TestCase
{

    /**
     * @test
     */
    function user_can_view_a_login_form()
    {
        $this->get('/login')
            ->assertSuccessful()
            ->assertViewIs('auth.login');
    }

    /**
     * @test
     */
    function user_cannot_view_a_login_form_when_authenticated()
    {
        $user = factory(User::class)->make();
        $this->actingAs($user)->get('/login')
            ->assertRedirect('/');
    }

    /**
     * @test
     */
    function user_can_login_with_correct_credentials()
    {
//        $user = factory(User::class)->create([
//            'password' => bcrypt($password = 'testpassword'),
//        ]);
//
//        $this->post(route('login'), [
//            'email'    => $user->email,
//            'password' => $password,
//        ]);
//
//
//
////        \Log::info($response);
//
//        $this->assertAuthenticatedAs($user);

    }

    /**
     * @test
     */
    public function user_can_get_token_after_login()
    {


    }

    /**
     * @test
     */
    function user_gets_a_correct_remember_me_cookie_if_chooses_to_be_remembered()
    {

    }

    /**
     * @test
     */
    function user_cannot_login_with_a_non_existent_email()
    {

    }

    /**
     * @test
     */
    function user_cannot_login_with_incorrect_password()
    {

    }

    /**
     * @test
     */

    function user_can_logout_when_already_authenticated()
    {

    }

    /**
     * @test
     */

    function user_cannot_attempt_to_login_more_than_five_times_in_one_minute()
    {

    }

}
