<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class AccountsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Debugging output: Starting the API request
        $this->command->info('Starting to fetch data from the external API');

        // Make a request to the external API using the provided test token
        $response = Http::withBasicAuth('test_token_ky6igyqi3qxa4', '')->get('https://api.teller.io/accounts');

        // Debugging output: Inspect the status code and response
        $this->command->info('API response status: ' . $response->status());

        if ($response->successful()) {
            $this->command->info('Successfully fetched data from the external API');

            $accounts = $response->json();

            // Debugging output: Inspect the fetched data
            $this->command->info('Fetched data: ' . json_encode($accounts));

            // Insert each account into the NexusBank database
            foreach ($accounts as $account) {
                DB::connection('nexusbank')->table('accounts')->insert([
                    'currency' => $account['currency'] ?? null,
                    'enrollment_id' => $account['enrollment_id'] ?? null,
                    'account_id' => $account['account_id'] ?? null,
                    'institution_id' => $account['institution_id'] ?? null,
                    'institution_name' => $account['institution_name'] ?? null,
                    'last_four' => $account['last_four'] ?? null,
                    'link_self' => $account['links']['self'] ?? null,
                    'link_details' => $account['links']['details'] ?? null,
                    'link_balances' => $account['links']['balances'] ?? null,
                    'link_transactions' => $account['links']['transactions'] ?? null,
                    'account_name' => $account['account_name'] ?? null,
                    'account_type' => $account['account_type'] ?? null,
                    'account_subtype' => $account['account_subtype'] ?? null,
                    'status' => $account['status'] ?? null,
                ]);
            }
        } else {
            // Debugging output: Error details
            $this->command->error('Failed to fetch data from the external API. Status: ' . $response->status());
            $this->command->error('Response: ' . $response->body());
        }
    }
}
