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
use PHPUnit\Framework\TestCase;

final class VersionTest extends TestCase {

    public function test_default_version_is_zero() : void {
        $version = new Version();
        $this->assertEquals(0, $version->value());
    }

    public function test_version_cannot_be_less_than_zero() : void {
        $this->expectException(InvalidArgumentException::CLASS);
        new Version(-1);
    }

    public function test_versions_are_comparable() : void {
        $v1 = new Version(10);
        $v2 = new Version(20);
        $v3 = new Version(30);

        $this->assertTrue($v1->equals(clone $v1));
        $this->assertTrue($v1->before($v2));
        $this->assertTrue($v3->after($v2));
    }

    public function test_bump_step_cannot_be_less_than_one() : void {
        $version = new Version();
        $this->expectException(InvalidArgumentException::CLASS);
        $version->bump(0);
    }

    public function test_bump_returns_new_version_with_an_updated_value() : void {
        $version = new Version(1);
        $this->assertEquals(1, $version->value());
        $bumped = $version->bump(); // default 1
        $this->assertNotSame($bumped, $version);
        $this->assertEquals(2, $bumped->value());
        $bumped = $bumped->bump(8);
        $this->assertEquals(10, $bumped->value());
    }

}