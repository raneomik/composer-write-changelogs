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

class FileOutputter extends AbstractOutputter
{
    public const TEXT_FORMAT = 'text';

    public const JSON_FORMAT = 'json';

    /**
     * @return string
     */
    public function getOutput(string $outputFormat)
    {
        $output = [];

        if ($this->isEmpty()) {
            if (self::TEXT_FORMAT === $outputFormat) {
                $output[] = 'No changelogs summary';
            }
        } else {
            if (self::JSON_FORMAT === $outputFormat) {
                $output = $this->handleJsonOutput($output);
            } else {
                $output[] = 'Changelogs summary:';
                foreach ($this->operations as $operation) {
                    $this->createOperationOutput($output, $operation);
                }
                $output[] = '';
            }
        }

        return self::JSON_FORMAT === $outputFormat ? json_encode($output, JSON_UNESCAPED_SLASHES) : implode("\n", $output);
    }

    /**
     * @param OperationInterface $operation
     * @param string|null        $outputFormat
     *
     * @return array|void
     */
    protected function createOperationJsonOutput(OperationInterface $operation)
    {
        $operationHandler = $this->getOperationHandler($operation);

        if (!$operationHandler) {
            return;
        }

        $urlGenerator = $this->getUrlGenerator(
            $operationHandler->extractSourceUrl($operation)
        );

        return $operationHandler->getOutput($operation, $urlGenerator);
    }

    /**
     * @param array $output
     *
     * @return array
     */
    private function handleJsonOutput(array $output)
    {
        $i = 0;
        foreach ($this->operations as $operation) {
            $output[$i] = $this->createOperationJsonOutput($operation);
            ++$i;
        }

        return $output;
    }
}
