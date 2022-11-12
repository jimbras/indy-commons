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
use PHPUnit\Framework\TestCase;

final class EventRecorderTest extends TestCase {

    use EventRecorder;

    public function test_event_is_recorded() : void {
        $this->assertEquals([], $this->events());
        $event = $this->createMock(Event::CLASS);
        $this->record($event);
        $this->assertSame([$event], $this->events());
    }

    public function test_events_are_flushed() : void {
        $event = $this->createMock(Event::CLASS);
        $this->record($event);
        $this->assertSame([$event], $this->events());
        $this->flush();
        $this->assertEquals([], $this->events());
    }

}