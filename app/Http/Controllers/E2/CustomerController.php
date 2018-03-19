<?php

namespace App\Http\Controllers\E2;

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
     * @return json
     */
    public function debt(string $id)
    {
        $inDebt = $this->data->getAccounts($id)->filter(function($value, $key) {
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
     * @return void
     */
    public function account(string $id, string $guid)
    {
        $account = $this->data->getAccount($guid, 'customer', $id);

        return response()->json([
            'data' => $account
        ]);
    }
}
