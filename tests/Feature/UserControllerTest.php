<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserControllerTest extends TestCase
{
    public function testLogin()
    {
        $this->get('/login')
            ->assertSeeText("Login");
    }
    public function testLoginSuccess()
    {
        $this->post('/login', [
            "user" => "kamal",
            "password" => "rahasia"
        ])->assertRedirect("/")
            ->assertSessionHas("user", "kamal");
    }
    public function testLoginValidationError()
    {
        $this->post("/login", [])
            ->assertSeeText("User or Password is Required");
    }

    public function testLoginFailed()
    {
        $this->post("user", [
            "user" => "wrong",
            "password" => "wrong"
        ])->assertSeeText("User or Password is wrong");
    }
    public function testLogout()
    {
        $this->withSession([
            "user" => "kamal"
        ])->post('/logout')
            ->assertRedirect("/")
            ->assertSessionMissing("user");
    }
}
