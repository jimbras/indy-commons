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

use ReflectionObject;
use Indy\Commons\Event;
use Indy\Commons\Version;
use Indy\Commons\Identity;
use PHPUnit\Framework\TestCase;

final class AbstractEntityTest extends TestCase {

    public function test_entity_default_state() : void {
        $id = $this->createMock(Identity::CLASS);
        $version = new Version();
        $entity = $this->getMockBuilder(AbstractEntity::CLASS)
            ->setConstructorArgs([$id, $version])
            ->getMockForAbstractClass();

        $this->assertSame($id, $entity->id());
        $this->assertSame($version, $entity->version());
        $this->assertEquals([], $entity->events());
    }

    public function test_record_stores_event() : void {
        $entity = $this->getMockBuilder(AbstractEntity::CLASS)
            ->setConstructorArgs([$this->createMock(Identity::CLASS), new Version()])
            ->getMockForAbstractClass();

        $ref = new ReflectionObject($entity);
        $recorder = $ref->getMethod('record');
        $recorder->setAccessible(true);

        $event = $this->createMock(Event::CLASS);
        $recorder->invoke($entity, $event);
        $recorder->invoke($entity, $event);

        $this->assertSame([$event, $event], $entity->events());
    }

    public function test_commit_stores_version_and_flushes_events() : void {
        $entity = $this->getMockBuilder(AbstractEntity::CLASS)
            ->setConstructorArgs([$this->createMock(Identity::CLASS), new Version()])
            ->getMockForAbstractClass();

        $ref = new ReflectionObject($entity);
        $recorder = $ref->getMethod('record');
        $recorder->setAccessible(true);

        $event = $this->createMock(Event::CLASS);
        $recorder->invoke($entity, $event);

        $this->assertSame([$event], $entity->events());

        $version = new Version(1);
        $this->assertNotSame($version, $entity->version());
        $entity->commit($version);


        $this->assertSame($version, $entity->version());
        $this->assertSame([], $entity->events());
    }

}