<?php

/*
 * This file is part of the composer-write-changelogs project.
 *
 * (c) Dev Spiriit <dev@spiriit.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Spiriit\ComposerWriteChangelogs\tests\resources;

use Composer\DependencyResolver\Operation\OperationInterface;

class FakeOperation implements OperationInterface
{
    /** @var string */
    private $text;

    /**
     * @param string $text
     */
    public function __construct($text)
    {
        $this->text = $text;
    }

    /**
     * @return string
     */
    public function getOperationType()
    {
        return '';
    }

    /**
     * @return string
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * @return string
     */
    public function getJobType()
    {
        return '';
    }

    /**
     * @return string
     */
    public function getReason()
    {
        return '';
    }

    /**
     * @param $lock
     *
     * @return string
     */
    public function show($lock)
    {
        return '';
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return '';
    }
}
