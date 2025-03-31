<?php

namespace Tests\Unit;

use App\Models\Concession;
use App\Repositories\ConcessionRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ConcessionRepositoryTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_creates_concession()
    {
        $repository = new ConcessionRepository();
        $data = [
            'name' => 'Pizza',
            'description' => 'Delicious pizza',
            'price' => 9.99,
            'image' => 'pizza.jpg',
        ];
        $concession = $repository->create($data);

        $this->assertDatabaseHas('concessions', [
            'name' => 'Pizza',
            'description' => 'Delicious pizza',
            'price' => 9.99,
            'image' => 'pizza.jpg',
        ]);
    }
}