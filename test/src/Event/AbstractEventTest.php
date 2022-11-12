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

use Indy\Commons\Identity;
use Indy\Commons\Timestamp;
use PHPUnit\Framework\TestCase;

final class AbstractEventTest extends TestCase {

    public function test_event_creates_timestamp_by_default() : void {
        $source = $this->createMock(Identity::CLASS);
        $event = $this->getMockBuilder(AbstractEvent::CLASS)
            ->setConstructorArgs([$source])
            ->getMockForAbstractClass();
        $this->assertSame($source, $event->source());
        $this->assertInstanceOf(Timestamp::CLASS, $event->time());
    }

    public function test_event_can_be_created_with_a_timestamp() : void {
        $source = $this->createMock(Identity::CLASS);
        $time = new Timestamp();
        $event = $this->getMockBuilder(AbstractEvent::CLASS)
            ->setConstructorArgs([$source, $time])
            ->getMockForAbstractClass();
        $this->assertSame($time, $event->time());
        $this->assertSame($source, $event->source());
    }

}