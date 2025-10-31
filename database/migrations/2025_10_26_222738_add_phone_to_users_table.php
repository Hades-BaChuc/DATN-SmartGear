<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(){ Schema::table('users', fn($t)=>$t->string('phone',30)->nullable()->after('email')); }
    public function down(){ Schema::table('users', fn($t)=>$t->dropColumn('phone')); }
};
