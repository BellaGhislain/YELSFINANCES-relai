 <?php

   use Illuminate\Database\Migrations\Migration;
   use Illuminate\Database\Schema\Blueprint;
   use Illuminate\Support\Facades\Schema;

   return new class extends Migration
   {
       public function up()
       {
           Schema::create('formation_trainer', function (Blueprint $table) {
               $table->id();
               $table->foreignId('formation_id')->constrained()->onDelete('cascade');
               $table->foreignId('trainer_id')->constrained()->onDelete('cascade');
               $table->timestamps();
           });
       }

       public function down()
       {
           Schema::dropIfExists('formation_trainer');
       }
   };
