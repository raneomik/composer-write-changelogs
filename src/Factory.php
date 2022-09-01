<?php

/*
 * This file is part of the composer-write-changelogs project.
 *
 * (c) Dev Spiriit <dev@spiriit.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Spiriit\ComposerWriteChangelogs;

use Spiriit\ComposerWriteChangelogs\Outputter\FileOutputter;
use Spiriit\ComposerWriteChangelogs\Outputter\Outputter;

class Factory
{
    /**
     * @return OperationHandler\OperationHandler[]
     */
    public static function createOperationHandlers()
    {
        return [
            new OperationHandler\Install\InstallHandler(),
            new OperationHandler\Update\UpdateHandler(),
            new OperationHandler\Uninstall\UninstallHandler(),
        ];
    }

    /**
     * @return OperationHandler\OperationHandler[]
     */
    public static function createOperationOutputFileHandlers(string $outputFormat)
    {
        return [
            new OperationHandler\Install\InstallOutputFileHandler($outputFormat),
            new OperationHandler\Update\UpdateOutputFileHandler($outputFormat),
            new OperationHandler\Uninstall\UninstallOutputFileHandler($outputFormat),
        ];
    }

    /**
     * @param string[] $gitlabHosts
     *
     * @return UrlGenerator\UrlGenerator[]
     */
    public static function createUrlGenerators(array $gitlabHosts = [])
    {
        $hosts = [
            new UrlGenerator\GithubUrlGenerator(),
            new UrlGenerator\BitbucketUrlGenerator(),
            new UrlGenerator\WordPressUrlGenerator(),
        ];

        foreach ($gitlabHosts as $gitlabHost) {
            $hosts[] = new UrlGenerator\GitlabUrlGenerator($gitlabHost);
        }

        return $hosts;
    }

    /**
     * @param string[] $gitlabHosts
     *
     * @return Outputter
     */
    public static function createOutputter(array $gitlabHosts = [])
    {
        return new Outputter(
            self::createOperationHandlers(),
            self::createUrlGenerators($gitlabHosts)
        );
    }

    /**
     * @param string[] $gitlabHosts
     *
     * @return FileOutputter
     */
    public static function createFileOutputter(string $outputFormat, array $gitlabHosts = [])
    {
        return new FileOutputter(
            self::createOperationOutputFileHandlers($outputFormat),
            self::createUrlGenerators($gitlabHosts)
        );
    }
}
