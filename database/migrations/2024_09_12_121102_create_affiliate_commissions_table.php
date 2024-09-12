<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('affiliate_commissions', function (Blueprint $table) {
            $table->id();
            $table->date('dt');
            $table->integer('visit_count')->default(0);
            $table->integer('registration_count')->default(0);
            $table->integer('qftd_count')->default(0);
            $table->integer('qlead_count')->default(0);
            $table->integer('deposit_count')->default(0);
            $table->decimal('deposit_total', 10, 2)->default(0);
            $table->decimal('net_pl', 10, 2)->default(0);
            $table->decimal('netwin', 10, 2)->default(0);
            $table->decimal('pl', 10, 2)->default(0);
            $table->integer('ftd_count')->default(0);
            $table->decimal('ftd_total', 10, 2)->default(0);
            $table->decimal('bonus_amount', 10, 2)->default(0);
            $table->integer('withdrawal_count')->default(0);
            $table->decimal('withdrawal_total', 10, 2)->default(0);
            $table->decimal('chargback_total', 10, 2)->default(0);
            $table->integer('operations')->default(0);
            $table->decimal('volume', 10, 2)->default(0);
            $table->decimal('commissions_cpl', 10, 2)->default(0);
            $table->decimal('commissions_cpa', 10, 2)->default(0);
            $table->decimal('commissions_rev_share', 10, 2)->default(0);
            $table->decimal('deductions', 10, 2)->default(0);
            $table->decimal('sub_commission_from_child', 10, 2)->default(0);
            $table->decimal('adjustments', 10, 2)->default(0);
            $table->decimal('payments', 10, 2)->default(0);
            $table->decimal('conversion_rate', 10, 2)->default(0);
            $table->decimal('net_deposit_total', 10, 2)->default(0);
            $table->decimal('commissions_total', 10, 2)->default(0);
            $table->decimal('balance', 10, 2)->default(0);
            $table->foreignId('affiliate_id')->nullable()->index()->constrained()->onDelete('set null');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('affiliate_commissions');
    }
};