<?php

namespace App\Http\Controllers\E3;

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
     * Search for accounts by first and/or last name
     * - I'm aware of the creeping high cognitive complexity of the nested
     * - IF statements. Not ideal, but quickly done to complete the bonus
     * - epic. Will be learning how to reduce it.
     *
     * @param Request $request
     * @param string $id
     * @return void
     */
    public function search(Request $request, string $id)
    {
        $firstname = $request->query('firstname');
        $lastname = $request->query('lastname');
        $accounts = $this->data->getAccounts($id);

        if ($firstname !== null || $lastname !== null) {
            if ($firstname !== null & $lastname === null) {
                $filtered = $accounts->each(function($value, $key) use ($firstname) { 
                    $name = strtolower($value->firstname);
                    $similarity = similar_text(strtolower($firstname), $name, $percentage);
                    $value->match = round($percentage, 2);
                });
            } elseif ($lastname !== null & $firstname === null) {
                $filtered = $accounts->each(function($value, $key) use ($lastname) { 
                    $name = strtolower($value->lastname);
                    $similarity = similar_text(strtolower($lastname), $name, $percentage);
                    $value->match = round($percentage, 2);
                });
            } else {
                $filtered = $accounts->each(function($value, $key) use ($firstname, $lastname) {
                    $firstnameSim = similar_text(strtolower($firstname), strtolower($value->firstname), $firstnamePerc);
                    $lastnameSim = similar_text(strtolower($lastname), strtolower($value->lastname), $lastnamePerc);
                    $percentage = ($firstnamePerc + $lastnamePerc) / 2;
                    $value->match = round($percentage, 2);
                });
            }
        } else {
            $filtered = $accounts;
        }

        return response()->json([
            'data' => $filtered->sortByDesc('match')->pluck('id')
        ], 200);
    }

    /**
     * List the accounts with balance in between given limits
     * - I'm aware of the creeping high cognitive complexity of the nested
     * - IF statements. Not ideal, but quickly done to complete the bonus
     * - epic. Will be learning how to reduce it.
     *
     * @param Request $request
     * @param string $id
     * @return void
     */
    public function balances(Request $request, string $id)
    {
        $min = $request->query('min');
        $max = $request->query('max');
        $accounts = $this->data->getAccounts($id);

        // Had to remove the commas in each balance to allow the min and max conditions to work.
        $accounts = $accounts->each(function($value, $key) {
            $value->balance = (string)str_replace(',', '', $value->balance);
        });

        if ($min !== null || $max !== null) {
            if ($min !== null & $max === null) {
                $filtered = $accounts->filter(function($value, $key) use ($min) { return $value->balance >= $min; });
            } elseif ($max !== null & $min === null) {
                $filtered = $accounts->filter(function($value, $key) use ($max) { return $value->balance <= $max; });
            } else {
                $filtered = $accounts->filter(function($value, $key) use ($min, $max) { 
                    return $value->balance >= $min && $value->balance <= $max; 
                });
            }
        } else {
            $filtered = $accounts;
        }

        return response()->json([
            'data' => $filtered->sortByDesc('balance')->pluck('id')
        ], 200);
    }
}
