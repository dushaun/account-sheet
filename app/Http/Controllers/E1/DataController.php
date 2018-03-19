<?php

namespace App\Http\Controllers\E1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DataController extends Controller
{
    /**
     * Load json data from file.
     *
     * @return Illuminate\Support\Collection
     */
    private function getData()
    {
        return json_decode(file_get_contents(database_path('json/a4a06bb0-3fbe-40bd-9db2-f68354ba742f.json')));
    }

    /**
     * Return the details of an account from a give guid.
     *
     * @param string $guid
     * @return Illuminate\Support\Collection
     */
    public function getAccount(string $guid)
    {
        $accounts = collect($this->getData()->accounts);
        $account = $accounts->firstWhere('id', $guid);

        return collect($account)->except('id', 'balance');
    }

    /**
     * Return a list of all accounts under the customer
     *
     * @return Illuminate\Support\Collection
     */
    public function getAccounts()
    {
        return collect($this->getData()->accounts);
    }

    /**
     * Return the balance of an account from a given guid.
     *
     * @param string $guid
     * @return Illuminate\Support\Collection
     */
    public function getBalance(string $guid)
    {
        $accounts = collect($this->getData()->accounts);
        $account = $accounts->firstWhere('id', $guid);

        return collect($account)->only('balance');
    }
}
