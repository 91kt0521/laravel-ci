<?php

namespace Tests\Feature;

use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ArticleControllerTest extends TestCase
{

    use RefreshDatabase;

    public function testIndex()
    {
        $response = $this->get(route('articles.index'));

        $response->assertStatus(200)
            ->assertViewIs('articles.index');
    }

    public function testGuestCreate()
    {
        $response = $this->get(route('articles.create'));

        $response->assertRedirect(route('login'));
    }

    public function testAuthCreate()
    {
        // ファクトリによって生成されたUserモデルがデータベースに保存され保存されたインスタンスを返す
        // テストに必要なUserモデルを「準備」
        $user = factory(User::class)->create();


        // actingAsメソッドはログインした状態を作る
        // ログインして記事投稿画面にアクセスすることを「実行」
        $response = $this->actingAs($user)
            ->get(route('articles.create'));

        // レスポンスを「検証」
        $response->assertStatus(200)
            ->assertViewIs('articles.create');
    }
}
