<?php

namespace Tests\Feature;

use App\Thread;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ThreadTest extends TestCase
{
    use DatabaseMigrations;
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testActionIndex()
    {
        $user = factory(\App\User::class)->create();
        $this->seed('ThreadsTableSeeder');

        $threads = Thread::orderBy('updated_at', 'desc')->paginate();

        $response = $this->actingAs($user)->json('GET', '/threads');

        $response->assertStatus(200)->assertJsonFragment([$threads->toArray()['data']]);
    }

    public function testActionStore()
    {
        $user = factory(\App\User::class)->create();

        $response = $this->actingAs($user)->json('POST', '/threads', [
                                                'title' => 'Meu primeiro post',
                                                'body' => 'Exemplo de tópico']);

        $thread = Thread::first();

        $response->assertStatus(200)
            ->assertJsonFragment(['created' => 'success'])
            ->assertJsonFragment([$thread->toArray()]);
    }

    public function testActionUpdate()
    {
        $user = factory(\App\User::class)->create();
        $thread = factory(\App\Thread::class)->create(
            [
                'user_id' => $user->id
            ]
        );

        $response = $this->actingAs($user)->json('PUT', '/threads/' . $thread->id, [
                                                'title' => 'Meu primeiro post atualizado',
                                                'body' => 'Exemplo de tópico']);

        $thread->title = 'Meu primeiro post atualizado';
        $thread->body ='Exemplo de tópico';

        $response->assertStatus(302);
        $this->assertEquals(Thread::first()->toArray(), $thread->toArray());
    }
}
