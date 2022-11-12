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

namespace Indy\Commons;

use InvalidArgumentException;

final class Version {

    private int $version;

    public function __construct(int $value = 0) {
        if ($value < 0) {
            throw new InvalidArgumentException('Invalid version value');
        }
        $this->value = $value;
    }

    public function value() : int {
        return $this->value;
    }

    public function equals(Version $other) : bool {
        return $this->value === $other->value;
    }

    public function before(Version $other) : bool {
        return $this->value < $other->value;
    }

    public function after(Version $other) : bool {
        return $this->value > $other->value;
    }

    public function bump(int $step = 1) : static {
        if ($step < 1) {
            throw new InvalidArgumentException('Invalid version bump value');
        }

        $version = clone $this;
        $version->value += $step;

        return $version;
    }

    /**
     * @codeCoverageIgnore
     */
    public function __toString() : string {
        return \sprintf('%s (value=%s)', self::CLASS, $this->value);
    }
}