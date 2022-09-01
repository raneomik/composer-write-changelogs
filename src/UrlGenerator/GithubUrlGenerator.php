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

class GithubUrlGenerator extends AbstractUrlGenerator
{
    /**
     * {@inheritdoc}
     */
    protected function getDomain()
    {
        return 'github.com';
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

        // Check if comparison across forks is needed
        if ($sourceUrlFrom !== $sourceUrlTo) {
            $repositoryFrom = $this->extractRepositoryInformation($sourceUrlFrom);
            $repositoryTo = $this->extractRepositoryInformation($sourceUrlTo);

            return sprintf(
                '%s/compare/%s:%s...%s:%s',
                $sourceUrlTo,
                $repositoryFrom['user'],
                $this->getCompareVersion($versionFrom),
                $repositoryTo['user'],
                $this->getCompareVersion($versionTo)
            );
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
            '%s/releases/tag/%s',
            $this->generateBaseUrl($sourceUrl),
            $version->getPretty()
        );
    }
}
