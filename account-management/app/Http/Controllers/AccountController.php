<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use App\Models\Account;
use Illuminate\Support\Facades\Http;

class AccountController extends Controller
{
    protected $client;

    public function __construct()
    {
        $this->client = new Client([
            'base_uri' => 'https://api.teller.io/',
            'verify' => true,
            'cert' => 'C:\Users\crstn\OneDrive\Documents\New folder/certificate.pem',
            'ssl_key' => 'C:\Users\crstn\OneDrive\Documents\New folder/private_key.pem',
            'headers' => [
                'Content-Type' => 'application/json',
                'Authorization' => 'Bearer' . env('TELLER_API_KEY'),

            ],
        ]);
    }

    public function listAccounts()
    {
        try {
            $response = $this->client->get('accounts');
            $accounts = json_decode($response->getBody()->getContents(), true);

            foreach ($accounts as $account) {
                $accountData = [
                    'enrollment_id' => $account['enrollment_id'],
                    'account_id' => $account['id'],
                    'institution_id' => $account['institution']['id'],
                    'institution_name' => $account['institution']['name'],
                    'last_four' => $account['last_four'],
                    'link_self' => $account['links']['self'],
                    'link_details' => $account['links']['details'],
                    'link_balances' => $account['links']['balances'],
                    'link_transactions' => $account['links']['transactions'],
                    'account_name' => $account['name'],
                    'account_type' => $account['type'],
                    'account_subtype' => $account['subtype'],
                    'status' => $account['status'],
                    'currency' => $account['currency'],
                ];

                Account::updateOrCreate(['account_id' => $accountData['account_id']], $accountData);
            }

            return response()->json($accounts);
        } catch (RequestException $e) {
            return response()->json(['error' => $e->getMessage()], $e->getCode());
        }
    }

    public function getAccount($accountId)
    {
        try {
            $response = $this->client->get("accounts/{$accountId}");
            $account = json_decode($response->getBody()->getContents(), true);
            return response()->json($account);
        } catch (RequestException $e) {
            return response()->json(['error' => $e->getMessage()], $e->getCode());
        }
    }

    public function deleteAccount($accountId)
    {
        try {
            $response = $this->client->delete("accounts/{$accountId}");
            if ($response->getStatusCode() === 204) {
                Account::where('account_id', $accountId)->delete();
                return response()->json(['message' => 'Account deleted successfully']);
            }
        } catch (RequestException $e) {
            return response()->json(['error' => $e->getMessage()], $e->getCode());
        }
    }

    public function deleteAllAccounts()
    {
        try {
            $response = $this->client->delete('accounts');
            if ($response->getStatusCode() === 204) {
                Account::truncate();
                return response()->json(['message' => 'All accounts deleted successfully']);
            }
        } catch (RequestException $e) {
            return response()->json(['error' => $e->getMessage()], $e->getCode());
        }
    }
}
