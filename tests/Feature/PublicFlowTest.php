<?php

namespace Tests\Feature;

use App\Livewire\Frontend\ArticleList;
use App\Livewire\Frontend\CommentSection;
use App\Livewire\Frontend\LikeBookmarkButtons;
use App\Livewire\Frontend\NewsletterForm;
use App\Mail\NewsletterVerificationMail;
use App\Models\Article;
use App\Models\Category;
use App\Models\Comment;
use App\Models\NewsletterSubscriber;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Livewire\Livewire;
use Tests\TestCase;

class PublicFlowTest extends TestCase
{
    use RefreshDatabase;

    public function test_article_page_shows_content_and_increments_views(): void
    {
        $article = Article::factory()->for(Category::factory())->for(User::factory(), 'author')->create(['views_count' => 5]);

        $response = $this->get(route('article.show', $article->slug));

        $response->assertOk()->assertSee($article->title);

        $this->assertEquals(6, $article->fresh()->views_count);
        $this->assertDatabaseCount('article_views', 1);
    }

    public function test_guest_comment_requires_moderation(): void
    {
        $article = Article::factory()->for(Category::factory())->for(User::factory(), 'author')->create();

        Livewire::test(CommentSection::class, ['article' => $article])
            ->set('guestName', 'Tamu')
            ->set('guestEmail', 'tamu@example.com')
            ->set('content', 'Komentar dari tamu untuk artikel ini.')
            ->call('submit')
            ->assertHasNoErrors();

        $this->assertDatabaseHas('comments', [
            'article_id' => $article->id,
            'status' => 'pending',
        ]);
    }

    public function test_authenticated_comment_is_auto_approved(): void
    {
        $user = User::factory()->create();
        $article = Article::factory()->for(Category::factory())->for(User::factory(), 'author')->create();

        Livewire::actingAs($user)
            ->test(CommentSection::class, ['article' => $article])
            ->set('content', 'Komentar dari pengguna terautentikasi.')
            ->call('submit')
            ->assertHasNoErrors();

        $this->assertDatabaseHas('comments', [
            'article_id' => $article->id,
            'user_id' => $user->id,
            'status' => 'approved',
        ]);
    }

    public function test_guest_cannot_like_article(): void
    {
        $article = Article::factory()->for(Category::factory())->for(User::factory(), 'author')->create();

        Livewire::test(LikeBookmarkButtons::class, ['article' => $article])
            ->call('toggleLike');

        $this->assertDatabaseCount('likes', 0);
    }

    public function test_authenticated_user_can_toggle_like(): void
    {
        $user = User::factory()->create();
        $article = Article::factory()->for(Category::factory())->for(User::factory(), 'author')->create();

        $component = Livewire::actingAs($user)->test(LikeBookmarkButtons::class, ['article' => $article]);

        $component->call('toggleLike');
        $this->assertDatabaseHas('likes', ['user_id' => $user->id, 'article_id' => $article->id, 'type' => 'like']);

        $component->call('toggleLike');
        $this->assertDatabaseMissing('likes', ['user_id' => $user->id, 'article_id' => $article->id, 'type' => 'like']);
    }

    public function test_newsletter_subscribe_sends_verification_mail(): void
    {
        Mail::fake();

        Livewire::test(NewsletterForm::class)
            ->set('email', 'reader@example.com')
            ->call('subscribe')
            ->assertHasNoErrors();

        $this->assertDatabaseHas('newsletter_subscribers', [
            'email' => 'reader@example.com',
            'is_verified' => false,
        ]);

        Mail::assertQueued(NewsletterVerificationMail::class);
    }

    public function test_newsletter_verify_link_activates_subscriber(): void
    {
        $subscriber = NewsletterSubscriber::create([
            'email' => 'reader2@example.com',
            'verification_token' => 'test-token-123',
            'is_verified' => false,
        ]);

        $response = $this->get(route('newsletter.verify', $subscriber->verification_token));

        $response->assertRedirect(route('home'));
        $this->assertTrue($subscriber->fresh()->is_verified);
    }

    public function test_homepage_renders_for_authenticated_user(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)->get(route('home'))->assertOk();
    }

    public function test_article_list_filters_by_category(): void
    {
        $categoryA = Category::factory()->create();
        $categoryB = Category::factory()->create();

        $matching = Article::factory()->for($categoryA)->for(User::factory(), 'author')->create();
        Article::factory()->for($categoryB)->for(User::factory(), 'author')->create();

        Livewire::test(ArticleList::class, ['category' => $categoryA])
            ->assertSee($matching->title);
    }

    public function test_comment_like_toggles(): void
    {
        $user = User::factory()->create();
        $article = Article::factory()->for(Category::factory())->for(User::factory(), 'author')->create();
        $comment = Comment::factory()->for($article)->create(['status' => 'approved']);

        $component = Livewire::actingAs($user)->test(CommentSection::class, ['article' => $article]);

        $component->call('toggleLike', $comment->id);
        $this->assertDatabaseHas('comment_likes', ['comment_id' => $comment->id, 'user_id' => $user->id]);

        $component->call('toggleLike', $comment->id);
        $this->assertDatabaseMissing('comment_likes', ['comment_id' => $comment->id, 'user_id' => $user->id]);
    }
}
