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

    private array $gitlabHosts;

    private ?string $changelogsDirPath;

    private string $outputFileFormat;

    private bool $writeSummaryFile;

    private ?string $webhookURL;

    public function __construct(array $gitlabHosts, ?string $changelogsDirPath, string $outputFileFormat, bool $writeSummaryFile, ?string $webhookURL)
    {
        $this->gitlabHosts = $gitlabHosts;
        $this->changelogsDirPath = $changelogsDirPath;
        $this->outputFileFormat = $outputFileFormat;
        $this->writeSummaryFile = $writeSummaryFile;
        $this->webhookURL = $webhookURL;
    }

    public function getGitlabHosts(): array
    {
        return $this->gitlabHosts;
    }

    public function getChangelogsDirPath(): ?string
    {
        return $this->changelogsDirPath;
    }

    public function getOutputFileFormat(): string
    {
        return $this->outputFileFormat;
    }

    /**
     */
    public function isWriteSummaryFile(): bool
    {
        return $this->writeSummaryFile;
    }

    /**
     * @return string
     */
    public function getWebhookURL(): ?string
    {
        return $this->webhookURL;
    }
}
