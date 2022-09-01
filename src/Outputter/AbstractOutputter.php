<?php

/*
 * This file is part of the composer-write-changelogs project.
 *
 * (c) Dev Spiriit <dev@spiriit.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Spiriit\ComposerWriteChangelogs\Outputter;

use Composer\DependencyResolver\Operation\OperationInterface;
use Spiriit\ComposerWriteChangelogs\OperationHandler\OperationHandler;
use Spiriit\ComposerWriteChangelogs\UrlGenerator\UrlGenerator;

abstract class AbstractOutputter
{
    /** @var OperationHandler[] */
    protected $operationHandlers;

    /** @var UrlGenerator[] */
    protected $urlGenerators;

    /** @var OperationInterface[] */
    protected $operations;

    /**
     * @param OperationHandler[] $operationHandlers
     * @param UrlGenerator[]     $urlGenerators
     */
    public function __construct(array $operationHandlers, array $urlGenerators)
    {
        $this->urlGenerators = $urlGenerators;
        $this->operationHandlers = $operationHandlers;
        $this->operations = [];
    }

    /**
     * @param OperationInterface $operation
     * @return void
     */
    public function addOperation(OperationInterface $operation): void
    {
        $this->operations[] = $operation;
    }

    /**
     * @return bool
     */
    public function isEmpty()
    {
        return empty($this->operations);
    }

    /**
     * @param array              $output
     * @param OperationInterface $operation
     *
     * @return void
     */
    protected function createOperationOutput(array &$output, OperationInterface $operation)
    {
        $operationHandler = $this->getOperationHandler($operation);

        if (!$operationHandler) {
            return;
        }

        $output[] = '';

        $urlGenerator = $this->getUrlGenerator(
            $operationHandler->extractSourceUrl($operation)
        );

        $output = array_merge(
            $output,
            $operationHandler->getOutput($operation, $urlGenerator)
        );
    }

    /**
     * @param OperationInterface $operation
     *
     * @return OperationHandler|null
     */
    protected function getOperationHandler(OperationInterface $operation)
    {
        foreach ($this->operationHandlers as $operationHandler) {
            if ($operationHandler->supports($operation)) {
                return $operationHandler;
            }
        }

        return null;
    }

    /**
     * @param string $sourceUrl
     *
     * @return UrlGenerator|null
     */
    protected function getUrlGenerator($sourceUrl)
    {
        foreach ($this->urlGenerators as $urlGenerator) {
            if ($urlGenerator->supports($sourceUrl)) {
                return $urlGenerator;
            }
        }

        return null;
    }
}
