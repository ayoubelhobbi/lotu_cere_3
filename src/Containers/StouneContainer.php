<?php

namespace Stoune\Containers;

use Plenty\Plugin\Templates\Twig;

class StouneContainer
{
    public function call(Twig $twig):string
    {
        return $twig->render('Stoune::Theme');
    }
}
