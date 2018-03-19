<?php

namespace Tests\Feature;

use Tests\TestCase;

class EpicOneTest extends TestCase
{
    private $accountId         = '8a28f09a-c234-4a95-b1e0-cdbc68979d0a';
    private $customerAccountId = '0dafb276-1620-42ce-bbc5-477209733d5c';

    /**
     * Test that the balance of the account id given is returned
     * 
     * @test
     */
    public function viewAccountBalance()
    {
        $response = $this->get("api/e1/account/{$this->accountId}/balance");

        $response->assertStatus(200)
            ->assertJson([
                'data' => ['balance' => '3,702.54']
            ]);
    }

    /**
     * Test that the details of the account id given are returned
     * 
     * @test
     */
    public function viewAccountDetails()
    {
        $response = $this->get("api/e1/account/{$this->accountId}/details");

        $response->assertStatus(200)
            ->assertJson([
                'data' => [
                    'firstname' => 'Cyrus',
                    'lastname'  => 'David',
                    'email'     => 'Cy.DAVI5969@dispostable.com',
                    'telephone' => '01721 578054'
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
     * - As this is testing localised JSON data, the customer is assumed in
     * - this case.
     * 
     * @test
     */
    public function viewCustomerDebt()
    {
        $response = $this->get("api/e1/customer/debt");

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
        $response = $this->get("api/e1/customer/account/{$this->customerAccountId}");

        $response->assertStatus(200)
            ->assertJson([
                'data' => [
                    'firstname' => 'Giana',
                    'lastname'  => 'Mueller',
                    'email'     => 'Gian.MUEL3296@yopmail.com',
                    'telephone' => '01178 766240'
                ]
            ])
            ->assertJsonMissing([
                'data' => ['id', 'balance']
            ]);
    }
}
