<?php

namespace App\Http\Controllers\E1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CustomerController extends Controller
{
    private $data;

    /**
     * Inject the Data Controller
     */
    public function __construct()
    {
        $this->data = new DataController();
    }

    /**
     * Return all the accounts that are in debt.
     *
     * @return Illuminate\Http\Response
     */
    public function debt()
    {
        $inDebt = $this->data->getAccounts()->filter(function($value, $key) {
            return $value->balance < 0;
        })->pluck('id');

        return response()->json([
            'data' => $inDebt
        ], 200);
    }

    /**
     * Return the details of the selected in debt account.
     *
     * @param string $guid
     * @return Illuminate\Http\Response
     */
    public function account(string $guid)
    {
        $account = $this->data->getAccount($guid);

        return response()->json([
            'data' => $account
        ]);
    }
}
