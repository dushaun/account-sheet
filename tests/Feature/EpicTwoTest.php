<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class EpicTwoTest extends TestCase
{
    private $accountId         = '27b60bcb-52f4-4e9f-9a4d-5529a7657388';
    private $customerId        = 'be0438bf-8b0d-4c57-913d-fcafb0bb41f0';
    private $customerAccountId = '30a9a548-f2d8-4045-922f-b9d03a0c953f';

    /**
     * Test that the balance of the account id given is returned
     * 
     * @test
     */
    public function viewAccountBalance()
    {
        $response = $this->get("api/e2/account/{$this->accountId}/balance");

        $response->assertStatus(200)
            ->assertJson([
                'data' => ['balance' => '-9,291.47']
            ]);
    }

    /**
     * Test that the details of the account id given are returned
     * 
     * @test
     */
    public function viewAccountDetails()
    {
        $response = $this->get("api/e2/account/{$this->accountId}/details");

        $response->assertStatus(200)
            ->assertJson([
                'data' => [
                    'firstname' => 'Sebastian',
                    'lastname'  => 'Henderson',
                    'email'     => 'Sebas.HEND2738@monumentmail.com',
                    'telephone' => '01148 092901'
                ]
            ])
            ->assertJsonMissing([
                'data' => ['id', 'balance']
            ]);
    }

    /**
     * Test that a list of account ids associated with the given customer id
     * is returned.
     * 
     * @test
     */
    public function viewCustomerDebt()
    {
        $response = $this->get("api/e2/customer/{$this->customerId}/debt");

        $response->assertStatus(200)
            ->assertJson([
                'data' => [1 => $this->customerAccountId]
            ]);
    }

    /**
     * Test that account details are returned to the customer from an
     * account id that is associated with it.
     * 
     * @test
     */
    public function viewCustomerAccountDetails()
    {
        $response = $this->get("api/e2/customer/{$this->customerId}/account/{$this->customerAccountId}");

        $response->assertStatus(200)
            ->assertJson([
                'data' => [
                    'firstname' => 'Jax',
                    'lastname'  => 'Fitzgerald',
                    'email'     => 'Jax.FITZG2289@yopmail.com',
                    'telephone' => '01281 774520'
                ]
            ])
            ->assertJsonMissing([
                'data' => ['id', 'balance']
            ]);
    }
}
