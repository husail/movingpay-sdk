<?php

declare(strict_types=1);

namespace Husail\MovingPay\Configuration;

final class MtlsConfiguration
{
    public function __construct(
        public readonly string $certificatePath,
        public readonly string $privateKeyPath,
        public readonly ?string $caBundlePath = null,
    ) {
        $this->validateFile($certificatePath, 'The mTLS certificate');
        $this->validateFile($privateKeyPath, 'The mTLS private key');

        if ($caBundlePath !== null && $caBundlePath !== '') {
            $this->validateFile($caBundlePath, 'The mTLS CA bundle');
        }
    }

    private function validateFile(string $path, string $label): void
    {
        if (!is_file($path) || !is_readable($path)) {
            throw new \InvalidArgumentException(sprintf('%s must be a readable file.', $label));
        }
    }
}
