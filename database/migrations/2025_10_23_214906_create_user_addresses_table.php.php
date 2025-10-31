<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up() {
        Schema::create('user_addresses', function (Blueprint $t) {
            $t->id();
            $t->foreignId('user_id')->constrained()->cascadeOnDelete();
            $t->string('full_name');
            $t->string('phone',20);
            $t->string('province')->nullable();
            $t->string('district')->nullable();
            $t->string('ward')->nullable();
            $t->string('street')->nullable();
            $t->boolean('is_default')->default(false);
            $t->timestamps();
        });
    }
    public function down(){ Schema::dropIfExists('user_addresses'); }
};
