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

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid as Ramsey;

final class _UUID4 extends UUID {
    use UUID4;
}

final class UUID4Test extends TestCase {

    public function test_default_constructor_generates_ramdon_uuids() : void {
        $id1 = new _UUID4();
        $id2 = new _UUID4();

        $this->assertNotEquals($id1->value(), $id2->value());
        $this->assertEquals(4, Ramsey::fromString($id1->value())->getFields()->getVersion());
        $this->assertEquals(4, Ramsey::fromString($id2->value())->getFields()->getVersion());
    }

    public function test_constructor_with_argument_recreates_uuid_if_its_valid() : void {
        $id1 = new _UUID4();
        $id2 = new _UUID4($id1->value());
        $this->assertEquals($id1->value(), $id2->value());
    }

    public function test_constructor_require_valid_uuid_string() : void {
        $this->expectException(InvalidArgumentException::CLASS);
        new _UUID4('bad-input');
    }

    public function test_constructor_require_valid_uuid4_string() : void {
        $this->expectException(InvalidArgumentException::CLASS);
        new _UUID4(Ramsey::uuid1()->toString());
    }

    public function test_uuid4_are_equatable() : void {
        $id1 = new _UUID4();
        $id2 = new _UUID4();

        $this->assertTrue($id1->equals(clone $id1));
        $this->assertFalse($id1->equals($id2));
    }

}