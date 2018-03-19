<?php

namespace App\Http\Controllers\E3;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use GuzzleHttp\Client;

class DataController extends Controller
{
    /**
     * Make the host string available to the class.
     *
     * @var string
     */
    private $host = 'https://mvf-devtest-s3api.s3-eu-west-1.amazonaws.com';

    /**
     * Load json data from file.
     *
     * @return Illuminate\Support\Collection
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
     * Return a list of all accounts under the customer
     *
     * @param string $id
     * @return Illuminate\Support\Collection
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
}
