<?php

// database/migrations/YYYY_MM_DD_create_rejected_transactions_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRejectedTransactionsTable extends Migration
{
    public function up()
    {
        Schema::create('rejected_transactions', function (Blueprint $table) {
            $table->id();
            $table->date('tanggal');
            $table->string('jenis');
            $table->string('kategori');
            $table->integer('jumlah');
            $table->string('keterangan');
            $table->string('gambar');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('rejected_transactions');
    }
}
