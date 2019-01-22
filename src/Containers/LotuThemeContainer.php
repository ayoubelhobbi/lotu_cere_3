<?php

namespace LotuTheme\Containers;

use Plenty\Plugin\Templates\Twig;

class LotuThemeContainer
{
    public function call(Twig $twig):string
    {
        return $twig->render('LotuTheme::Theme');
    }
}