<?php

namespace Tests\Feature\Admin;

use App\Models\User;
use App\Models\Article;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ArticleTest extends TestCase
{
    use RefreshDatabase;

    private User $admin;

    protected function setUp(): void
    {
        parent::setUp();
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        $role        = \Spatie\Permission\Models\Role::create(['name' => 'admin', 'guard_name' => 'web']);
        $this->admin = User::factory()->create();
        $this->admin->assignRole($role);
    }

    private function actingAsAdmin(): static
    {
        return $this->actingAs($this->admin);
    }

    /** @test */
    public function index_page_loads(): void
    {
        $this->actingAsAdmin()
             ->get(route('admin.articles.index'))
             ->assertOk();
    }

    /** @test */
    public function create_page_loads(): void
    {
        $this->actingAsAdmin()
             ->get(route('admin.articles.create'))
             ->assertOk();
    }

    /** @test */
    public function admin_can_create_article(): void
    {
        $this->actingAsAdmin()
             ->post(route('admin.articles.store'), [
                 'title'   => 'Tips Persiapan Umrah',
                 'content' => 'Isi artikel yang panjang dan informatif tentang persiapan umrah.',
                 'status'  => 'published',
             ])
             ->assertRedirect(route('admin.articles.index'));

        $this->assertDatabaseHas('articles', ['title' => 'Tips Persiapan Umrah', 'status' => 'published']);
    }

    /** @test */
    public function creating_article_without_title_fails(): void
    {
        $response = $this->actingAsAdmin()
                         ->post(route('admin.articles.store'), [
                             'content' => 'Isi artikel.',
                             'status'  => 'published',
                         ]);

        $response->assertSessionHasErrors('title');
        $this->assertDatabaseEmpty('articles');
    }

    /** @test */
    public function creating_article_without_content_fails(): void
    {
        $response = $this->actingAsAdmin()
                         ->post(route('admin.articles.store'), [
                             'title'  => 'Judul Artikel',
                             'status' => 'published',
                         ]);

        $response->assertSessionHasErrors('content');
    }

    /** @test */
    public function creating_article_with_invalid_status_fails(): void
    {
        $response = $this->actingAsAdmin()
                         ->post(route('admin.articles.store'), [
                             'title'   => 'Judul Artikel',
                             'content' => 'Isi artikel.',
                             'status'  => 'invalid_status',
                         ]);

        $response->assertSessionHasErrors('status');
    }

    /** @test */
    public function admin_can_update_article(): void
    {
        $article = Article::create([
            'title'     => 'Judul Lama',
            'slug'      => 'judul-lama',
            'content'   => 'Konten lama.',
            'author_id' => $this->admin->id,
            'status'    => 'draft',
        ]);

        $this->actingAsAdmin()
             ->put(route('admin.articles.update', $article->id), [
                 'title'   => 'Judul Baru',
                 'content' => 'Konten baru yang telah diperbarui.',
                 'status'  => 'published',
             ])
             ->assertRedirect(route('admin.articles.index'));

        $this->assertDatabaseHas('articles', ['title' => 'Judul Baru', 'status' => 'published']);
    }

    /** @test */
    public function admin_can_delete_article(): void
    {
        $article = Article::create([
            'title'     => 'Hapus Ini',
            'slug'      => 'hapus-ini',
            'content'   => 'Isi.',
            'author_id' => $this->admin->id,
            'status'    => 'draft',
        ]);

        $this->actingAsAdmin()
             ->delete(route('admin.articles.destroy', $article->id))
             ->assertRedirect();

        $this->assertDatabaseMissing('articles', ['id' => $article->id]);
    }

    /** @test */
    public function thumbnail_must_be_image(): void
    {
        $response = $this->actingAsAdmin()
                         ->post(route('admin.articles.store'), [
                             'title'     => 'Artikel Gambar',
                             'content'   => 'Isi artikel.',
                             'status'    => 'published',
                             'thumbnail' => UploadedFile::fake()->create('doc.pdf', 500, 'application/pdf'),
                         ]);

        $response->assertSessionHasErrors('thumbnail');
    }
}
