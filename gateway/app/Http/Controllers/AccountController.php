<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use GuzzleHttp\RequestOptions;
use App\Models\Account;
use Illuminate\Support\Facades\Http;

class AccountController extends Controller
{
    use LoggerTrait;

    protected $client;

    public function __construct()
    {
        $this->client = new Client([
            'base_uri' => 'https://api.teller.io/',
            'verify' => true,
            'cert' => 'C:\xampp2\htdocs\nexusbank\account-management\certificate.pem',
            'ssl_key' => 'C:\xampp2\htdocs\nexusbank\account-management\private_key.pem',
            'headers' => [
                'Content-Type' => 'application/json',
                'Authorization' => 'Bearer ' . env('TELLER_API_KEY'),
            ],
        ]);
    }

    public function fetchAccounts()
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
            $this->logInfo('Fetching accounts...');

            return response()->json(['message' => 'Accounts fetched and stored successfully']);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function listAccounts()
    {
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . env('TELLER_API_KEY'),
        ])->get('https://api.teller.io/accounts');

        if ($response->successful()) {
            $accounts = $response->json();

            $formattedAccounts = collect($accounts)->map(function ($account) {
                return [
                    'enrollment_id' => $account['enrollment_id'],
                    'links' => [
                        'balances' => $account['links']['balances'],
                        'self' => $account['links']['self'],
                        'transactions' => $account['links']['transactions'],
                    ],
                    'institution' => [
                        'name' => $account['institution']['name'],
                        'id' => $account['institution']['id'],
                    ],
                    'type' => $account['type'],
                    'name' => $account['name'],
                    'subtype' => $account['subtype'],
                    'currency' => $account['currency'],
                    'id' => $account['id'],
                    'last_four' => $account['last_four'],
                    'status' => $account['status'],
                ];
            });

            return response()->json($formattedAccounts);
        }

        return response()->json(['error' => 'Failed to fetch accounts'], $response->status());
    }

    public function getAccount($accountId)
    {
        try {
            $response = $this->client->get("accounts/{$accountId}");
            $account = json_decode($response->getBody()->getContents(), true);
            return response()->json($account);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function deleteAccount($accountId)
    {
        try {
            $response = $this->client->delete("accounts/{$accountId}");
            if ($response->getStatusCode() === 204) {
                return response()->json(['message' => 'Account deleted successfully']);
            } else {
                return response()->json(['error' => 'Failed to delete account'], $response->getStatusCode());
            }
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function deleteAllAccounts()
    {
        try {
            $response = $this->client->delete('accounts');
            if ($response->getStatusCode() === 204) {
                return response()->json(['message' => 'All accounts deleted successfully']);
            } else {
                return response()->json(['error' => 'Failed to delete all accounts'], $response->getStatusCode());
            }
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
