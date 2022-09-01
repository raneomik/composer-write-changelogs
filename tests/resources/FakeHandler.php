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
use Spiriit\ComposerWriteChangelogs\OperationHandler\OperationHandler;
use Spiriit\ComposerWriteChangelogs\UrlGenerator\UrlGenerator;
use Spiriit\ComposerWriteChangelogs\Version;

class FakeHandler implements OperationHandler
{
    /** @var bool */
    private $supports;

    /** @var string */
    private $sourceUrl;

    /** @var string */
    private $output;

    /**
     * @param bool   $supports
     * @param string $sourceUrl
     * @param string $output
     */
    public function __construct($supports, $sourceUrl, $output)
    {
        $this->supports = $supports;
        $this->sourceUrl = $sourceUrl;
        $this->output = $output;
    }

    /**
     * {@inheritdoc}
     */
    public function supports(OperationInterface $operation)
    {
        return $this->supports;
    }

    /**
     * {@inheritdoc}
     */
    public function extractSourceUrl(OperationInterface $operation)
    {
        return $this->sourceUrl;
    }

    /**
     * {@inheritdoc}
     */
    public function getOutput(OperationInterface $operation, UrlGenerator $urlGenerator = null)
    {
        if (!($operation instanceof FakeOperation)) {
            return [];
        }

        $output = [
            ' - ' . $this->output . ', ' . $operation->getText(),
        ];

        if ($urlGenerator) {
            $output[] = '   ' . $urlGenerator->generateCompareUrl($this->sourceUrl, new Version('', '', ''), $this->sourceUrl, new Version('', '', ''));
            $output[] = '   ' . $urlGenerator->generateReleaseUrl($this->sourceUrl, new Version('', '', ''));
        }

        return $output;
    }
}
