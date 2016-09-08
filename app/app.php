<?php
    require_once __DIR__.'/../vendor/autoload.php';
    require_once __DIR__.'/../src/Cd.php';

    session_start();
    if (empty($_SESSION['cds'])) {
        $_SESSION['cds'] = array();
        $first_cd = new CD("Master of Reality", "Black Sabbath", "img/master.jpg", 10.99);
        $second_cd = new CD("Electric Ladyland", "Jimi Hendrix", "img/ladyland.jpg", 10.99);
        $third_cd = new CD("Nevermind", "Nirvana", "img/nevermind.jpg", 10.99);
        $fourth_cd = new CD("I don't get it", "Pork Lion", "img/porklion.jpg", 49.99);
        $fifth_cd = new CD("The Cry of Love", "Jimi Hendrix", "img/cry.jpg", 7.99);
        $sixth_cd = new CD("Are You Experienced?", "Jimi Hendrix", "img/experienced.jpg", 9.99);
        $seventh_cd = new CD("Before We Ever Minded", "Nirvana", "img/before.jpg", 17.99);
        $eigth_cd = new CD("Paranoid", "Black Sabbath", "img/paranoid.jpg", 9.49);
        $ninth_cd = new CD("Bleach", "Nirvana", "img/bleach.jpg", 1.99);
        $tenth_cd = new CD("Mob Rules", "Black Sabbath", "img/mob.jpg", 8.99);
        $eleventh_cd = new CD("In Utero", "Nirvana", "img/utero.jpg", 22.99);
    }

    $app = new Silex\Application();

    $app->register(new Silex\Provider\TwigServiceProvider(), array('twig.path' => __DIR__.'/../views'));

    $app->get("/", function() use ($app) {
        return $app['twig']->render('home.html.twig', array('cds' => CD::getAll()));
    });

    $app->post("/search-results", function() use ($app) {
        $cds_matching_search = array();
        foreach ($_SESSION['cds'] as $cd) {
            $artist = $cd->getArtist();
            if(stripos($artist, $_POST['search-term']) !== false) {
                array_push($cds_matching_search, $cd);
            }
        }
        return $app['twig']->render('search-results.html.twig', array('cds' => $cds_matching_search));
    });

    return $app;
?>
