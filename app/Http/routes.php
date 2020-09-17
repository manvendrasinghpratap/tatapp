    <?php
        Route::get('/lang/{locale?}', [
            'as'=>'lang',
            'uses'=>'HomeController@changeLang'
        ]);
    ?>