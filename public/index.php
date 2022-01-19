<?php
    //header('Access-Control-Allow-Origin: *');
    require "../vendor/autoload.php";

    use App\Controller\AuthController;
    use App\Controller\Usercontroller;
    use Symfony\Component\Routing\Generator\UrlGenerator;
    use Symfony\Component\Routing\Matcher\UrlMatcher;
    use Symfony\Component\Routing\RequestContext;
    use Symfony\Component\HttpFoundation\Request;
    use Symfony\Component\Routing\Route;
    use Symfony\Component\Routing\RouteCollection;
    use Symfony\Component\Routing\Exception\ResourceNotFoundException;



    // develloppement requirement .
    $whoops = new \Whoops\Run;
    $whoops->pushHandler(new \Whoops\Handler\PrettyPageHandler);
    $whoops->register();



    try{
      
        $routes = new RouteCollection();

        $routes->add('login', (new Route('/login', ['_controller' => AuthController::class, "method"=>"login"])));
        $routes->add('register', (new Route('/register', ['_controller' => AuthController::class, "method"=>"register"])));
        $routes->add('user_post', (new Route('/user', ['_controller' => Usercontroller::class, "method"=>"index"])));

        $context = new RequestContext();
        $context->fromRequest(Request::createFromGlobals());
    
        // Init UrlMatcher object
        $matcher = new UrlMatcher($routes, $context);
    
        // Find the current route
        $parameters = $matcher->match($context->getPathInfo());

        //dump($parameters);

        $controller = $parameters['_controller'];
        $method = $parameters['method'];
        (new $controller())->$method();
        exit();

    }catch (ResourceNotFoundException $e){
      echo $e->getMessage();
    }

?>