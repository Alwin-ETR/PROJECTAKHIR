<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('suspensions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->text('reason');
            $table->dateTime('suspended_at');
            $table->dateTime('suspended_until')->nullable();
            $table->string('status')->default('active'); // active, inactive, expired
            $table->foreignId('created_by')->nullable()->constrained('users')->onDelete('set null');
            $table->text('notes')->nullable();
            $table->timestamps();
            
            $table->index('user_id');
            $table->index('status');
            $table->index('suspended_until');
        });
    }

    public function down()
    {
        Schema::dropIfExists('suspensions');
    }
};
