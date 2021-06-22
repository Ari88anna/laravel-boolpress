<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateAddCategories extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        // creiamo una colonna dentro post che sarà la foreign key

        Schema::table('posts', function (Blueprint $table) {

            //creiamo la colonna
            $table->unsignedBigInteger('category_id')->nullable()->after('slug'); 

            $table->foreign('category_id')
                ->references('id')  //che fa riferimento alla colonna id
                ->on('categories'); //della tabella categories

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('posts', function (Blueprint $table) {

            $table->dropForeign('posts_category_id_foreign');
            $table->dropColumn('category_id');

            // E' possibile che dropColumn non sia sufficiente per le foreign key, 
            // quindi prima di farlo utilizziamo il metodo dropForeign()  
            // passando come argomento il nome della tabella underscore nome della colonna seguito da _foreign            

        });
    }
}
