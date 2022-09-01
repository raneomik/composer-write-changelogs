<?php

/*
 * This file is part of the composer-write-changelogs project.
 *
 * (c) Dev Spiriit <dev@spiriit.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Spiriit\ComposerWriteChangelogs\tests;

use Composer\Composer;
use Composer\Config;
use Composer\Package\RootPackage;
use PHPUnit\Framework\TestCase;
use Spiriit\ComposerWriteChangelogs\Config\ConfigLocator;

class ConfigLocatorTest extends TestCase
{
    /** @var false|string|null */
    private $localConfigPath;

    /** @var false|string|null */
    private $globalConfigPath;

    /** @var ConfigLocator */
    private $SUT;

    /**
     * {@inheritdoc}
     */
    protected function setUp(): void
    {
        $this->localConfigPath = realpath(__DIR__ . '/../fixtures/local');
        $this->globalConfigPath = realpath(__DIR__ . '/../fixtures/home');

        $config = new Config(false, $this->localConfigPath);
        $config->merge([
            'config' => [
                'home' => $this->globalConfigPath,
            ],
        ]);

        $package = new RootPackage('my/project', '1.0.0', '1.0.0');
        $package->setExtra([
            'my-local-config' => [
                'foo' => 'bar',
            ],
        ]);

        $composer = new Composer();
        $composer->setConfig($config);
        $composer->setPackage($package);

        $this->SUT = new ConfigLocator($composer);
    }

    /**
     * @test
     */
    public function testItLocatesLocalConfig(): void
    {
        $key = 'my-local-config';

        $this->assertTrue($this->SUT->locate($key));

        $this->assertSame($this->localConfigPath, $this->SUT->getPath($key));
        $this->assertSame(['foo' => 'bar'], $this->SUT->getConfig($key));
    }

    /**
     * @test
     */
    public function testItLocatesGlobalConfig(): void
    {
        $key = 'my-global-config';

        $this->assertTrue($this->SUT->locate($key));

        $this->assertSame($this->globalConfigPath, $this->SUT->getPath($key));
        $this->assertSame(['bar' => 'foo'], $this->SUT->getConfig($key));
    }

    /**
     * @test
     */
    public function testItDoesNotLocateNonExistingConfig(): void
    {
        $key = 'my-non-existing-config';

        $this->assertFalse($this->SUT->locate($key));

        $this->assertNull($this->SUT->getPath($key));
        $this->assertSame([], $this->SUT->getConfig($key));
    }
}
