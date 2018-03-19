<?php

namespace App\Http\Controllers\E2;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use GuzzleHttp\Client;

class DataController extends Controller
{
    private $host = 'https://mvf-devtest-s3api.s3-eu-west-1.amazonaws.com';

    /**
     * Create array of customer ID and associated json filename.
     * - This is created so when a customer gives their id, the associated
     * - file will be used to download the json data for that customer.
     * 
     * - If it is just a customer, then the account data from all three 
     * - customers gets merged into one json array that can be queried.
     * - This logic is done in the next method
     *
     * @return json
     */
    private function getData()
    {
        $data = file_get_contents($this->host);
        $xml = simplexml_load_string($data);

        foreach($xml->children() as $key => $item) {
            if ($key === 'Contents') {
                $files[] = $item;
            }
        }

        $customers = collect(json_decode(json_encode($files)))->map(function($value, $key) {
            return [
                'id' => substr($value->Key, 0, -5),
                'file' => $value->Key
            ];
        });

        return $customers;
    }

    /**
     * Return the details of an account from a give guid.
     * - If its a customer, only the accounts in the customer's json file
     * - will be downloaded. If its an account, all accounts from the three
     * - files gets downloaded so the correct account can be found.
     *
     * @param string $guid
     * @return void
     */
    public function getAccount(string $guid, string $from = null, string $id = null)
    {
        if ($from === 'customer') {
            $accounts = $this->getAccounts($id);
            $account = $accounts->firstWhere('id', $guid);
        } elseif ($from === 'account') {
            $accounts = collect([]);
            $this->getData()->each(function($value, $key) use ($accounts) {
                $json = json_decode(file_get_contents($this->host . '/' . $value['file']));
                $accounts->push($json->accounts);
            });

            $account = $accounts->flatten()->firstWhere('id', $guid);
        }
        
        return collect($account)->except('id', 'balance');
    }

    /**
     * Return a list of all accounts under the customer
     *
     * @return void
     */
    public function getAccounts(string $id)
    {
        $accounts = collect([]);
        $this->getData()->filter(function($value, $key) use ($id, $accounts) {
            if ($value['id'] === $id) {
                $json = json_decode(file_get_contents($this->host . '/' . $value['file']));
                $accounts->push($json->accounts);
            }
        });

        return collect($accounts->flatten());
    }

    /**
     * Return the balance of an account from a given guid.
     *
     * @param string $guid
     * @return void
     */
    public function getBalance(string $guid)
    {
        $accounts = collect([]);
        $this->getData()->each(function($value, $key) use ($accounts) {
            $json = json_decode(file_get_contents($this->host . '/' . $value['file']));
            $accounts->push($json->accounts);
        });

        $account = $accounts->flatten()->firstWhere('id', $guid);

        return collect($account)->only('balance');
    }
}
