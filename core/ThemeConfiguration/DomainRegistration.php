<?php

declare(strict_types=1);

namespace Rombt\ThemeCore\ThemeConfiguration;

use Rombt\ThemeCore\ThemeConfiguration\Contracts\ConfigurationDomainInterface;
use Rombt\ThemeCore\ThemeConfiguration\Contracts\DomainValidatorInterface;

final readonly class DomainRegistration
{
    /**
     * @param class-string<ConfigurationDomainInterface> $domainClass
     */
    public function __construct(
        private DomainId $id,
        private string $domainClass,
        private DomainValidatorInterface $validator,
    ) {
    }

    public function id(): DomainId
    {
        return $this->id;
    }

    /**
     * @return class-string<ConfigurationDomainInterface>
     */
    public function domainClass(): string
    {
        return $this->domainClass;
    }

    public function validator(): DomainValidatorInterface
    {
        return $this->validator;
    }
}
