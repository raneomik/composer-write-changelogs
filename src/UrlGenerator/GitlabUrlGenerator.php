<?php

/*
 * This file is part of the composer-write-changelogs project.
 *
 * (c) Dev Spiriit <dev@spiriit.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Spiriit\ComposerWriteChangelogs\UrlGenerator;

use Spiriit\ComposerWriteChangelogs\Version;

class GitlabUrlGenerator extends AbstractUrlGenerator
{
    /** @var string */
    private $host;

    /**
     * @param string $host
     */
    public function __construct($host)
    {
        $this->host = $host;
    }

    /**
     * {@inheritdoc}
     */
    protected function getDomain()
    {
        return $this->host;
    }

    /**
     * {@inheritdoc}
     */
    public function generateCompareUrl($sourceUrlFrom, Version $versionFrom, $sourceUrlTo, Version $versionTo)
    {
        // Check if both urls come from the supported domain
        // It avoids problems when one url is from another domain or is local
        if (!$this->supports($sourceUrlFrom) || !$this->supports($sourceUrlTo)) {
            return false;
        }

        $sourceUrlFrom = $this->generateBaseUrl($sourceUrlFrom);
        $sourceUrlTo = $this->generateBaseUrl($sourceUrlTo);

        if ($sourceUrlFrom !== $sourceUrlTo) {
            // Comparison across forks is not supported
            return false;
        }

        return sprintf(
            '%s/compare/%s...%s',
            $sourceUrlTo,
            $this->getCompareVersion($versionFrom),
            $this->getCompareVersion($versionTo)
        );
    }

    /**
     * {@inheritdoc}
     */
    public function generateReleaseUrl($sourceUrl, Version $version)
    {
        if ($version->isDev()) {
            return false;
        }

        return sprintf(
            '%s/tags/%s',
            $this->generateBaseUrl($sourceUrl),
            $version->getPretty()
        );
    }
}
