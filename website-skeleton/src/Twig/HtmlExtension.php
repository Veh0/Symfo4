<?php

namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class HtmlExtension extends AbstractExtension {


    public function getFilters() {
        return [
            new TwigFilter('figure', [$this, 'figureFilter'])
        ];
    }

    public function figureFilter($image, $desc) {
        $link="<img src='".$image."' alt=''><br><p>".$desc."</p>";
        
        return $link;
    }
}
