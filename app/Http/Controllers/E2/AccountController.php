<?php

namespace App\Http\Controllers\E2;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AccountController extends Controller
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
     * Get the balance for the given GUID
     *
     * @param string $guid
     * @return json
     */
    public function balance(string $guid)
    {
        $balance = $this->data->getBalance($guid);

        return response()->json([
            'data' => $balance
        ], 200);
    }

    /**
     * Get the details for the given GUID
     *
     * @param string $guid
     * @return json
     */
    public function details(string $guid)
    {
        $account = $this->data->getAccount($guid, 'account');

        return response()->json([
            'data' => $account
        ], 200);
    }
}