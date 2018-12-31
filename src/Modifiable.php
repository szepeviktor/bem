<?php # -*- coding: utf-8 -*-

/*
 * This file is part of the bem package.
 *
 * (c) Guido Scialfa <dev@guidoscialfa.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
declare(strict_types=1);

namespace Widoz\Bem;

/**
 * Class Modifiable
 *
 * @author Guido Scialfa <dev@guidoscialfa.com>
 */
interface Modifiable extends \IteratorAggregate
{
    /**
     * @return string
     */
    public function stringify(): string;
}