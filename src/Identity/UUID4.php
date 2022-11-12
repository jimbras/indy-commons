<?php declare(strict_types=1);

/**
 *  This program is free software: you can redistribute it and/or modify
 *  it under the terms of the GNU Affero General Public License as
 *  published by the Free Software Foundation, either version 3 of the
 *  License, or (at your option) any later version.
 *
 *  This program is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU Affero General Public License for more details.
 *
 *  You should have received a copy of the GNU Affero General Public License
 *  along with this program. If not, see <https://www.gnu.org/licenses/agpl-3.0.txt>.
 */

namespace Indy\Commons\Identity;

use Ramsey\Uuid\Uuid;
use InvalidArgumentException;
use Ramsey\Uuid\UuidInterface;
use Ramsey\Uuid\Exception\InvalidUuidStringException;

trait UUID4 {

    protected function create() : UuidInterface {
        return Uuid::uuid4();
    }

    protected function recreate(string $value) : UuidInterface {
        try {
            $uuid = Uuid::fromString($value);
        } catch (InvalidUuidStringException $x) {
            throw new InvalidArgumentException(\sprintf('Invalid UUID4 value for %s', static::CLASS));
        }

        if (4 !== $uuid->getFields()->getVersion()) {
            throw new InvalidArgumentException(\sprintf('Invalid UUID4 value for %s', static::CLASS));
        }

        return $uuid;
    }

}