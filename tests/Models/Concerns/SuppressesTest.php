<?php

namespace Tests\Models\Concerns;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use LucasDotVin\Soulbscription\Models\Subscription;
use Tests\TestCase;

class SuppressesTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    public const MODEL = Subscription::class;

    public function testModelReturnsSuppressedWhenSuppressedAtIsOnThePast(): void
    {
        $model = self::MODEL::factory()->make([
            'suppressed_at' => now()->subDay(),
        ]);

        $this->assertTrue($model->suppressed());
        $this->assertFalse($model->notSuppressed());
    }

    public function testModelReturnsNotSuppressedWhenSuppressedAtIsOnTheFuture(): void
    {
        $model = self::MODEL::factory()->make([
            'suppressed_at' => now()->addDay(),
        ]);

        $this->assertFalse($model->suppressed());
        $this->assertTrue($model->notSuppressed());
    }

    public function testModelReturnsNotSuppressedWhenSuppressedAtIsNull(): void
    {
        $model                = self::MODEL::factory()->make();
        $model->suppressed_at = null;

        $this->assertFalse($model->suppressed());
        $this->assertTrue($model->notSuppressed());
    }
}
