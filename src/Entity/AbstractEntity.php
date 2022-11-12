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

namespace Indy\Commons\Entity;

use Indy\Commons\Entity;
use Indy\Commons\Version;
use Indy\Commons\Identity;
use Indy\Commons\Event\EventRecorder;

abstract class AbstractEntity implements Entity {

    use EventRecorder;

    public function __construct(
        private Identity $id,
        private Version $version
    ) {}

    public function id() : Identity {
        return $this->id;
    }

    public function version() : Version {
        return $this->version;
    }

    public function commit(Version $version) : void {
        $this->version = $version;
        $this->flush();
    }

    /**
     * @codeCoverageIgnore
     */
    public function __toString() : string {
        return \sprintf('%s (id=%s)', static::CLASS, $this->id->value());
    }
}