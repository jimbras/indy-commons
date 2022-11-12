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

final class Timestamp {

    private float $value;

    public function __construct(float $value = null) {
        $now = \microtime(true);
        if (null === $value) {
            $this->value = $now;
        } else if ($value >= 0.0 && ($now - $value) > \PHP_FLOAT_EPSILON) {
            $this->value = $value;
        } else {
            throw new InvalidArgumentException('Invalid timestamp value');
        }
    }

    public function value() : float {
        return $this->value;
    }

    public function equals(Timestamp $other) : bool {
        return 0 === $this->compare($other);
    }

    public function before(Timestamp $other) : bool {
        return -1 === $this->compare($other);
    }

    public function after(Timestamp $other) : bool {
        return 1 === $this->compare($other);
    }

    public function compare(Timestamp $other) : int {
        if (\abs($this->value - $other->value) < \PHP_FLOAT_EPSILON) {
            return 0;
        } else if ($other->value - $this->value > \PHP_FLOAT_EPSILON) {
            return -1;
        }
        return 1;
    }

    /**
     * @codeCoverageIgnore
     */
    public function __toString() : string {
        return \sprintf('%s (value=%s)', self::CLASS, $this->value);
    }

}