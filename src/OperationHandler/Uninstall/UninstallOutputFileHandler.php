<?php

/*
 * This file is part of the composer-write-changelogs project.
 *
 * (c) Dev Spiriit <dev@spiriit.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Spiriit\ComposerWriteChangelogs\OperationHandler\Uninstall;

use Composer\DependencyResolver\Operation\OperationInterface;
use Composer\DependencyResolver\Operation\UninstallOperation;
use Composer\Package\PackageInterface;
use Composer\Package\Version\VersionParser;
use Spiriit\ComposerWriteChangelogs\Outputter\FileOutputter;
use Spiriit\ComposerWriteChangelogs\UrlGenerator\UrlGenerator;
use Spiriit\ComposerWriteChangelogs\Version;

class UninstallOutputFileHandler extends AbstractUninstallHandler
{
    /**
     * @var string
     */
    private $outputFormat;

    public function __construct(string $outputFormat)
    {
        $this->outputFormat = $outputFormat;
    }

    public function getOutput(OperationInterface $operation, UrlGenerator $urlGenerator = null)
    {
        if (!($operation instanceof UninstallOperation)) {
            throw new \LogicException('Operation should be an instance of UninstallOperation');
        }

        $package = $operation->getPackage();
        $version = new Version(
            $package->getVersion(),
            $package->getPrettyVersion(),
            method_exists($package, 'getFullPrettyVersion') // This method was added after composer v1.0.0-alpha10
                ? $package->getFullPrettyVersion()
                : VersionParser::formatVersion($package)
        );

        if (FileOutputter::JSON_FORMAT === $this->outputFormat) {
            return $this->getJsonOutput($package, $version, $urlGenerator);
        } else {
            return $this->getTextOutput($package, $version, $urlGenerator);
        }
    }

    /**
     * @param PackageInterface $package
     * @param Version          $version
     *
     * @return array
     */
    private function getJsonOutput(PackageInterface $package, Version $version)
    {
        $output = [];

        $output['operation'] = 'uninstall';
        $output['package'] = $package->getName();
        $output['phrasing'] = 'removed';
        $output['version'] = $version->getCliOutput();

        return $output;
    }

    /**
     * @param PackageInterface $package
     * @param Version          $version
     *
     * @return array
     */
    private function getTextOutput(PackageInterface $package, Version $version)
    {
        $output = [];

        $output[] = sprintf(
            ' - %s removed (installed version was %s)',
            $package->getName(),
            $version->getCliOutput()
        );

        return $output;
    }
}
