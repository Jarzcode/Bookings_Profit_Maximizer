<?php

namespace SFL\Shared\Infrastructure\Persistence\Doctrine\DBAL;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Platforms\MySQLPlatform;
use Doctrine\DBAL\Types\Type;
use Ramsey\Uuid\Uuid as RamseyUuid;
use SFL\Shared\Domain\Uuid;

class UuidDbType extends Type
{
    public const NAME = 'uuid_db_type';

    public function getSQLDeclaration(array $fieldDeclaration, AbstractPlatform $platform): string
    {
        if ($platform instanceof MySQLPlatform) {
            return 'BINARY(16)';
        }

        return $platform->getBinaryTypeDeclarationSQL($fieldDeclaration);
    }

    public function convertToPHPValue($value, AbstractPlatform $platform): mixed
    {
        if ($value === null) {
            return null;
        }

        return Uuid::create(RamseyUuid::fromBytes($value)->toString());
    }

    public function convertToDatabaseValue($value, AbstractPlatform $platform): mixed
    {
        if ($value === null) {
            return null;
        }

        return RamseyUuid::fromString($value)->getBytes();
    }

    public function getName(): string
    {
        return self::NAME;
    }

    public function requiresSQLCommentHint(AbstractPlatform $platform): bool
    {
        return true;
    }
}
