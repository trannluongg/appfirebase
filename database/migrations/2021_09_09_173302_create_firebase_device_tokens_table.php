<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFirebaseDeviceTokensTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('firebase_device_tokens', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('fdt_user_id')->default(0);
            $table->string('fdt_token', 191);
            $table->tinyInteger('fdt_type')->default(1);
            $table->text('fdt_agent');
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
        Schema::dropIfExists('firebase_device_tokens');
    }
}
