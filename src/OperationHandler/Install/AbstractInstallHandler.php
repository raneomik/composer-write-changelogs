<?php

/*
 * This file is part of the composer-write-changelogs project.
 *
 * (c) Dev Spiriit <dev@spiriit.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Spiriit\ComposerWriteChangelogs\OperationHandler\Install;

use Composer\DependencyResolver\Operation\InstallOperation;
use Composer\DependencyResolver\Operation\OperationInterface;
use Spiriit\ComposerWriteChangelogs\OperationHandler\OperationHandler;
use Spiriit\ComposerWriteChangelogs\UrlGenerator\UrlGenerator;

abstract class AbstractInstallHandler implements OperationHandler
{
    /**
     * @param OperationInterface $operation
     *
     * @return bool
     */
    public function supports(OperationInterface $operation)
    {
        return $operation instanceof InstallOperation;
    }

    /**
     * @param OperationInterface $operation
     *
     * @return string|null
     */
    public function extractSourceUrl(OperationInterface $operation)
    {
        if (!($operation instanceof InstallOperation)) {
            throw new \LogicException('Operation should be an instance of InstallOperation');
        }

        return $operation->getPackage()->getSourceUrl();
    }

    /**
     * @param OperationInterface $operation
     * @param UrlGenerator|null  $urlGenerator
     *
     * @return array|void
     */
    public function getOutput(OperationInterface $operation, UrlGenerator $urlGenerator = null)
    {
    }
}
