<?php
namespace Tests\Unit;

use App\Repositories\Stock\StockRepositoryInterface;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Services\StockQuoteService;
use Mockery;

class StocksTest extends TestCase
{
    use RefreshDatabase;

    #[\PHPUnit\Framework\Attributes\Test]
    public function it_retrieves_stock_quote_successfully()
    {
        $mockService = Mockery::mock(StockQuoteService::class);
        $mockService->shouldReceive('fetchQuote')->andReturn([
            'name' => 'IBM',
            'symbol' => 'IBM',
            'open' => 258.58,
            'high' => 259.8696,
            'low' => 255.79,
            'price' => 258.63,
            'date' => '2025-05-23',
            'close' => 258.37,
        ]);
        $this->app->instance(StockQuoteService::class, $mockService);

        $user = User::factory()->create();

        $token = JWTAuth::fromUser($user);

        $response = $this->postJson('/api/v1/stocks/quote', ['symbol' => 'IBM'], ['Authorization' => "Bearer $token"]);

        $response->assertStatus(200);
        $response->assertJson([
            'data' => [
                'name' => 'IBM',
                'symbol' => 'IBM',
                'price' => 258.63,
                'open' => 258.58,
                'high' => 259.8696,
                'low' => 255.79,
                'close' => 258.37,
                'date' => '2025-05-23',
            ],
        ]);
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function it_retrieves_stock_history_successfully()
    {
        $mockRepository = Mockery::mock(StockRepositoryInterface::class);
        $mockRepository->shouldReceive('get')->andReturn([
            'rows' => [
                [
                    'id' => 8,
                    'name' => 'TSLA',
                    'symbol' => 'TSLA',
                    'price' => 339.34,
                    'open' => 337.92,
                    'high' => 343.18,
                    'low' => 333.21,
                    'close' => 341.04,
                    'date' => '2025-05-23',
                    'userId' => 4,
                    'createdAt' => '2025-05-25T21:01:05.000000Z',
                    'updatedAt' => '2025-05-25T21:01:05.000000Z'
                ]
            ],
            'count' => 12
        ]);
        $this->app->instance(StockRepositoryInterface::class, $mockRepository);

        $user = User::factory()->create();

        $token = JWTAuth::fromUser($user);

        $response = $this->getJson('/api/v1/stocks/history', ['Authorization' => "Bearer $token"]);

        $response->assertStatus(200);
        $response->assertJson([
            'data' => [
                'items' => [
                    [
                        'id' => 8,
                        'name' => 'TSLA',
                        'symbol' => 'TSLA',
                        'price' => 339.34,
                        'open' => 337.92,
                        'high' => 343.18,
                        'low' => 333.21,
                        'close' => 341.04,
                        'date' => '2025-05-23',
                        'userId' => 4,
                        'createdAt' => '2025-05-25T21:01:05.000000Z',
                        'updatedAt' => '2025-05-25T21:01:05.000000Z'
                    ]
                ],
                'recordsTotal' => 12
            ]
        ]);
    }
}
