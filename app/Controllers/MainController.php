<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Generators\CatGenerator;
use App\Generators\DogeGenerator;
use App\Generators\MultiGenerator;
use App\Generators\ValidatingGenerator;
use Illuminate\Contracts\Container\Container;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Laravel\Lumen\Routing\Controller;

/**
 * This is the main controller class.
 *
 * @author Graham Campbell <graham@alt-three.com>
 */
class MainController extends Controller
{
    /**
     * Show the homepage.
     *
     * @param \Illuminate\Contracts\View\Factory $view
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Factory $view)
    {
        return new Response($view->make('index'));
    }

    /**
     * Generate the memes.
     *
     * @param \Illuminate\Contracts\Container\Container $container
     * @param \Illuminate\Http\Request                  $request
     *
     * @return \Illuminate\Http\Response
     */
    public function generate(Container $container, Request $request)
    {
        $doge = $request->get('type') == "doge"

        $inner = $container->make($doge ? DogeGenerator::class : CatGenerator::class);

        $generator = new ValidatingGenerator(new MultiGenerator($inner, $doge ? 2 : 3));

        $images = $generator->start((string) $request->get('text'))->wait();

        return new JsonResponse([
            'success' => ['message' => 'Here are your memes!'],
            'data'    => ['images' => $images],
        ]);
    }
}
