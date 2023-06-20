<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('currencies', function (Blueprint $table) {
            $table->id();
            $table->string('country', 100);
            $table->string('currency', 100);
            $table->string('code', 25);
            $table->string('symbol', 25);
            $table->string('thousand_separator', 10);
            $table->string('decimal_separator', 10);
            $table->nullableTimestamps();
        });
        Schema::create('businesses', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->foreignId('currency_id');
            $table->date('start_date')->nullable();
            $table->string('tax_number_1', 100);
            $table->string('tax_label_1', 10);
            $table->string('tax_number_2', 100)->nullable();
            $table->string('tax_label_2', 10)->nullable();
            $table->float('default_profit_percent', 5, 2)->default(0);
            $table->foreignId('owner_id');
            $table->foreign('owner_id')->references('id')->on('users')->onDelete('cascade');
            $table->string('time_zone')->default('Asia/Phnom_Penh');
            $table->tinyInteger('fy_start_month')->default(1);
            $table->enum('accounting_method', ['fifo', 'lifo', 'avco'])->default('fifo');
            $table->decimal('default_sales_discount', 5, 2)->nullable();
            $table->enum('sell_price_tax', ['includes', 'excludes'])->default('includes');
            $table->foreign('currency_id')->references('id')->on('currencies');
            $table->string('logo')->nullable();
            $table->string('sku_prefix')->nullable();
            $table->boolean('enable_tooltip')->default(1);
            $table->softDeletes();
            $table->timestamps();
        });
        Schema::create('business_locations', function (Blueprint $table) {
            $table->increments('id');
            $table->foreignId('business_id');
            $table->foreign('business_id')->references('id')->on('businesses')->onDelete('cascade');
            $table->string('name', 256);
            $table->text('landmark')->nullable();
            $table->string('country', 100);
            $table->string('state', 100);
            $table->string('city', 100);
            $table->char('zip_code', 7);
            $table->string('mobile')->nullable();
            $table->string('alternate_number')->nullable();
            $table->string('email')->nullable();
            $table->softDeletes();
            $table->timestamps();

            //Indexing
            $table->index('business_id');
        });
        Schema::create('contacts', function (Blueprint $table) {
            $table->increments('id');
            $table->foreignId('business_id');
            $table->foreign('business_id')->references('id')->on('businesses')->onDelete('cascade');
            $table->string('type')->index();
            $table->string('supplier_business_name')->nullable();
            $table->string('name');
            $table->string('tax_number')->nullable();
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->string('country')->nullable();
            $table->string('landmark')->nullable();
            $table->string('mobile');
            $table->string('landline')->nullable();
            $table->string('alternate_number')->nullable();
            $table->integer('pay_term_number')->nullable();
            $table->enum('pay_term_type', ['days', 'months'])->nullable();
            $table->foreignId('created_by');
            $table->boolean('is_default')->default(0);
            $table->softDeletes();
            $table->foreign('created_by')->references('id')->on('users')->onDelete('cascade');
            $table->timestamps();
        });

        Schema::create('packages', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->text('description');
            $table->integer('location_count')->comment('No. of Business Locations, 0 = infinite option.');
            $table->integer('user_count');
            $table->integer('product_count');
            $table->integer('invoice_count');
            $table->enum('interval', ['days', 'months', 'years']);
            $table->integer('interval_count');
            $table->integer('trial_days');
            $table->decimal('price', 22, 4);
            $table->integer('created_by');
            $table->integer('sort_order')->default(0);
            $table->boolean('is_active');
            $table->softDeletes();
            $table->timestamps();
        });
        Schema::create('subscriptions', function (Blueprint $table) {
            $table->increments('id');

            $table->foreignId('business_id');
            $table->foreign('business_id')->references('id')->on('businesses')->onDelete('cascade');
            $table->integer('package_id')->unsigned();
            $table->date('start_date')->nullable();
            $table->date('trial_end_date')->nullable();
            $table->date('end_date')->nullable();
            $table->decimal('package_price', 22, 4);
            $table->longText('package_details');
            $table->foreignId('created_id');
            $table->string('paid_via')->nullable();
            $table->string('payment_transaction_id')->nullable();
            $table->enum('status', ['approved', 'waiting', 'declined'])->default('waiting');
            $table->softDeletes();
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
        Schema::dropIfExists('currencies');
        Schema::dropIfExists('businesses');
        Schema::dropIfExists('business_locations');
        Schema::dropIfExists('contacts');
        Schema::dropIfExists('packages');
        Schema::dropIfExists('subscriptions');
    }
};
