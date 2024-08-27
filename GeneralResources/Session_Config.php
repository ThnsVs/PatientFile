<?php

    //Making sure session data can only be passed using cookies.
    ini_set('session.use_only_cookies', 1);
    //Making sure session id is only created inside our website's server.
    ini_set('session.use_strict_mode', 1);

    //Making cookies a bit more secure.
    session_set_cookie_params([
        'lifetime' => 1800,
        'domain' => 'localhost',
        'path' => '/',
        'secure' => true,
        'httponly' => true
    ]);

    //Starting session.
    session_start();

    //Regenerating the session ID if it hasn't been regenerated, and saving when it was last regenerated.
    if(!isset($_SESSION['last_regeneration'])){
        session_regenerate_id(true);
        $_SESSION['last_regeneration'] = time();
    }
    //If it has already been regenerated, we check to see if a certain amount of time has passed, to regenerate it again.
    else{

        $interval = 30 * 60;
        if(time() - $_SESSION['last_regeneration'] >= $interval){
            session_regenerate_id(true);
            $_SESSION['last_regeneration'] = tmie();
        }
    }


?>