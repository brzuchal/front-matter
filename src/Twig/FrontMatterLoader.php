<?php

/*
 * This is part of the webuni/front-matter package.
 *
 * (c) Martin Hasoň <martin.hason@gmail.com>
 * (c) Webuni s.r.o. <info@webuni.cz>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Webuni\FrontMatter\Twig;

use Twig\Loader\LoaderInterface;
use Twig\Source;
use Webuni\FrontMatter\FrontMatterInterface;

class FrontMatterLoader implements LoaderInterface
{
    private $loader;
    private $parser;

    public function __construct(FrontMatterInterface $parser, LoaderInterface $loader)
    {
        $this->loader = $loader;
        $this->parser = $parser;
    }

    public function getCacheKey($name): string
    {
        return $this->loader->getCacheKey($name);
    }

    public function isFresh($name, $time): bool
    {
        return $this->loader->isFresh($name, $time);
    }

    public function exists($name)
    {
        return $this->loader->exists($name);
    }

    public function getSourceContext($name): Source
    {
        $source = $this->loader->getSourceContext($name);

        return new Source($this->parser->parse($source->getCode(), ['filename' => $name]), $source->getName(), $source->getPath());
    }
}
