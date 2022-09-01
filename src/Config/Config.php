<?php

/*
 * This file is part of the composer-write-changelogs project.
 *
 * (c) Dev Spiriit <dev@spiriit.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Spiriit\ComposerWriteChangelogs\Config;

class Config
{
    public const CHANGELOGS_DIR = 'changelogs';

    /** @var string[] */
    private $gitlabHosts;

    /** @var string */
    private $changelogsDirPath;

    /**
     * @var string
     */
    private $outputFileFormat;

    /**
     * @param array  $gitlabHosts
     * @param string $changelogsDirPath
     * @param string $outputFileFormat
     */
    public function __construct(array $gitlabHosts, $changelogsDirPath, $outputFileFormat)
    {
        $this->gitlabHosts = $gitlabHosts;
        $this->changelogsDirPath = $changelogsDirPath;
        $this->outputFileFormat = $outputFileFormat;
    }

    /**
     * @return string[]
     */
    public function getGitlabHosts()
    {
        return $this->gitlabHosts;
    }

    /**
     * @return string
     */
    public function getChangelogsDirPath()
    {
        return $this->changelogsDirPath;
    }

    /**
     * @return string
     */
    public function getOutputFileFormat()
    {
        return $this->outputFileFormat;
    }
}
