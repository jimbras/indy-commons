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

namespace Indy\Commons\Event;

use Indy\Commons\Event;
use Indy\Commons\Identity;
use Indy\Commons\Timestamp;

abstract class AbstractEvent implements Event {

    private Timestamp $time;
    private Identity $source;

    public function __construct(Identity $source, Timestamp $time = null) {
        $this->time = $time ?: new Timestamp();
        $this->source = $source;
    }

    public function time() : Timestamp {
        return $this->time;
    }

    public function source() : Identity {
        return $this->source;
    }

    /**
     * @codeCoverageIgnore
     */
    public function __toString() : string {
        return \sprintf('%s (time=%s,source=%s)', static::CLASS, $this->time->value(), $this->source->value());
    }

}