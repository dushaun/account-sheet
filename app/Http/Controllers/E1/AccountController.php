<?php

namespace App\Http\Controllers\E1;

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
     * @return Illuminate\Http\Response
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
     * @return Illuminate\Http\Response
     */
    public function details(string $guid)
    {
        $account = $this->data->getAccount($guid);

        return response()->json([
            'data' => $account
        ], 200);
    }
}
