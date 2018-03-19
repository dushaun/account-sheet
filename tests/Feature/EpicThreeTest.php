<?php

namespace Tests\Feature;

use Tests\TestCase;

class EpicThreeTest extends TestCase
{
    private $customerId = 'be9b2a8b-e846-4365-8d5f-0fca4ef9aefb';

    /**
     * @test
     */
    public function searchCustomerAccountsWithoutQuery()
    {
        $response = $this->get("api/e3/customer/{$this->customerId}/search");

        $response->assertStatus(200)
            ->assertJson([
                'data' => [1 => '8036e163-334c-43ce-8d02-f429c08b7009']
            ]);
    }

    /**
     * @test
     */
    public function searchCustomerAccountsWithFirstnameQuery()
    {
        $response = $this->get("api/e3/customer/{$this->customerId}/search?firstname=Melina");

        $response->assertStatus(200)
            ->assertJson([
                'data' => [0 => '51f0aac0-fcb5-4f15-82c1-4fe5fbd05f1f']
            ]);
    }

    /**
     * @test
     */
    public function searchCustomerAccountsWithLastnameQuery()
    {
        $response = $this->get("api/e3/customer/{$this->customerId}/search?lastname=Meyer");

        $response->assertStatus(200)
            ->assertJson([
                'data' => [0 => '6d943f7c-889c-42d2-9447-c62bdb86c14e']
            ]);
    }

    /**
     * @test
     */
    public function searchCustomerAccountsWithFirstAndLastnameQuery()
    {
        $response = $this->get("api/e3/customer/{$this->customerId}/search?firstname=Azaria&lastname=Scott");

        $response->assertStatus(200)
            ->assertJson([
                'data' => [0 => '00f2476e-2bd8-4677-9503-f06548f04757']
            ]);
    }

    /**
     * @test
     */
    public function searchCustomerAccountBalancesWithoutQuery()
    {
        $response = $this->get("api/e3/customer/{$this->customerId}/balances");

        $response->assertStatus(200)
            ->assertJson([
                'data' => [2 => '1373d3f4-ad20-4266-bab1-b62cd23e0e78']
            ]);
    }

    /**
     * @test
     */
    public function searchCustomerAccountBalancesWithMinimumQuery()
    {
        $response = $this->get("api/e3/customer/{$this->customerId}/balances?min=-500");

        $response->assertStatus(200)
            ->assertJson([
                'data' => [2 => '1373d3f4-ad20-4266-bab1-b62cd23e0e78']
            ])
            ->assertJsonMissing([
                'data' => [99 => '1a6a5899-c2f0-4c8f-9e9a-e37d2a187f46']
            ]);
    }

    /**
     * @test
     */
    public function searchCustomerAccountBalancesWithMaximumQuery()
    {
        $response = $this->get("api/e3/customer/{$this->customerId}/balances?max=1000");

        $response->assertStatus(200)
            ->assertJson([
                'data' => [2 => '7f381b44-b6ee-44c9-a052-381b01e6e973']
            ])
            ->assertJsonMissing([
                'data' => [3 => 'cb43e9fe-ca92-4dba-8d0a-e06ec770e156']
            ]);
    }

    /**
     * @test
     */
    public function searchCustomerAccountBalancesWithMinimumAndMaximumQuery()
    {
        $response = $this->get("api/e3/customer/{$this->customerId}/balances?min=-500&max=1000");

        $response->assertStatus(200)
            ->assertJson([
                'data' => [2 => '7f381b44-b6ee-44c9-a052-381b01e6e973']
            ])
            ->assertJsonMissing([
                'data' => [
                    3 => 'cb43e9fe-ca92-4dba-8d0a-e06ec770e156',
                    5 => 'be6f6eff-07a7-4c22-94ef-7924b505323f'
                ]
            ]);
    }
}
