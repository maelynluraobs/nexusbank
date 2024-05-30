<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAccounts extends Migration 
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('accounts', function (Blueprint $table) {
            $table->string('currency', 3)->nullable();
            $table->string('enrollment_id', 255)->nullable();
            $table->string('account_id', 255)->primary();
            $table->string('institution_id', 255)->nullable();
            $table->string('institution_name', 255)->nullable();
            $table->string('last_four', 4)->nullable();
            $table->string('link_self', 255)->nullable();
            $table->string('link_details', 255)->nullable();
            $table->string('link_balances', 255)->nullable();
            $table->string('link_transactions', 255)->nullable();
            $table->string('account_name', 255)->nullable();
            $table->string('account_type', 50)->nullable();
            $table->string('account_subtype', 50)->nullable();
            $table->string('status', 10)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('accounts');
    }
};
