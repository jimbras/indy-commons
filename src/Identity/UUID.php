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

use Indy\Commons\Identity;
use Ramsey\Uuid\UuidInterface;

abstract class UUID implements Identity {

    private string $value;

    public function __construct(string $value = null) {

        $uuid = null === $value
            ? $this->create()
            : $this->recreate($value);

        $this->value = $uuid->toString();
    }

    protected abstract function create() : UuidInterface;

    /**
     * @throws InvalidArgumentException
     */
    protected abstract function recreate(string $value) : UuidInterface;

    public function value() : string {
        return $this->value;
    }

    public function equals(Identity $other) : bool {
        return $other instanceof static && 0 === \strcasecmp($this->value, $other->value);
    }

    /**
     * @codeCoverageIgnore
     */
    public function __toString() : string {
        return \sprintf('%s (value=%s)', static::CLASS, $this->value);
    }
}