The Twig-Broiler
============

Basic setup to get you started with Twig. For setting up:

1. Copy templates to your template directory
2. Modify `base_project.html.twig` to match your general project template
3. You may want to alter all project specific variables (starting with `{{ app.`) to match your project variables
4. Add more templates for special views

For more information see [Twig Documentation](http://twig.sensiolabs.org/). Twig is used by [Symfony2](http://symfony.com/doc/current/book/templating.html), [Silex](http://silex.sensiolabs.org/doc/providers/twig.html) and [Drupal 8+](http://anthonyringoet.be/post/introduction-to-twig/).

Installation in Symfony
-----

1. Copy files from `/TwigBroiler/Ressources/views` to `/app/Ressources/views/`
2. Create new bundle in `/src/TwigBroilerBundle` via `php app/console generate:bundle`
3. Copy all files to `/src/TwigBroilerBundle`
4. Create `/src/TwigFiltersBundle/Ressources/config/services.yml`

Installation in Silex
-----

1. Copy files from `/TwigBroiler/Ressources/views` to `/app/views/`
2. Copy files from `/TwigBroiler` to `/src/TwigBroiler`
3. Copy these lines to `/app/app.php`

```
$loader->add('TwigBroiler', realpath(__DIR__.'/../src'));


$app['asset_path'] = '';
$app['locale']     = 'de';
$app['config']['frontend'] = array(
	'title' => '…',
	'description' => '…',
);

$app->register(new Silex\Provider\TwigServiceProvider(), array(
	'twig.path' => __DIR__.'/views',
));
$app['twig']->addExtension(new \TwigBroiler\Twig\CsvExtension());
$app['twig']->addExtension(new \TwigBroiler\Twig\HelperExtension());
$app['twig']->addExtension(new \TwigBroiler\Twig\HtmlExtension());
$app['twig']->addExtension(new \TwigBroiler\Twig\JsExtension());
$app['twig']->addExtension(new \TwigBroiler\Twig\SocialMediaExtension());

$app->before(function () use ($app) {
	$app['twig']->addGlobal('base', $app['twig']->loadTemplate('base.html.twig'));
	$app['twig']->addGlobal('base_project', $app['twig']->loadTemplate('base_project.html.twig'));
});
```

Version
-------

Version: 0.9 (2014-07-25)

Legal stuff
-----------

Author: [Frank Boës](http://3960.org)

Copyright & license: See LICENSE.txt