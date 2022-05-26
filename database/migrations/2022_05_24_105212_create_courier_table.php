<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('couriers', function (Blueprint $table) {
            $table->id();
            $table->string('courier_name',25);
            $table->string('courier_code',25);
            $table->timestamps();
        });
        Schema::create('packages', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('courier_id');
            $table->string('resi',225);
            $table->string('status',10);
            $table->string('desc',100);
            $table->unsignedInteger('weight');
            $table->unsignedInteger('amount');
            $table->timestamp('start_date');
            $table->timestamp('finish_date');
            $table->timestamps();
            $table->foreign('courier_id')->references('id')->on('couriers');

        });
        Schema::create('trackings', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('package_id');
            $table->string('tracking',255);
            $table->timestamps();
            $table->foreign('package_id')->references('id')->on('packages');

        });
        Schema::create('details', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('package_id');
            $table->string('origin',100);
            $table->string('destination',100);
            $table->string('sender',100);
            $table->string('reciever',100);
            $table->timestamps();
            $table->foreign('package_id')->references('id')->on('packages');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('details');
        Schema::dropIfExists('trackings');
        Schema::dropIfExists('packages');
        Schema::dropIfExists('couriers');
    }
};
