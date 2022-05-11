<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->string("payment_name");
            $table->string("account_number")->nullable();
            $table->string("ref_number")->nullable();
            $table->string("image")->nullable();
            $table->enum("type",['personal','agent','mmerchant']);
            $table->tinyInteger("status")->default(0)->comment('0=active=1inactive');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('payments');
    }
}
