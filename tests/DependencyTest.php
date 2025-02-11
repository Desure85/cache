<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace Yiisoft\Cache\Tests;

use Yiisoft\Cache\Dependencies\Dependency;
use Yiisoft\Cache\SimpleCache;

/**
 * Dependency (abstract) tests.
 * @group caching
 * @author Boudewijn Vahrmeijer <vahrmeijer@gmail.com>
 */
class DependencyTest extends TestCase
{
    public function testResetReusableData()
    {
        $value = ['dummy'];
        $dependency = new MockDependency();
        $this->setInaccessibleProperty($dependency, '_reusableData', $value, false);
        $this->assertEquals($value, $this->getInaccessibleProperty($dependency, '_reusableData'));

        $dependency->resetReusableData();

        $this->assertEquals([], $this->getInaccessibleProperty($dependency, '_reusableData'));
    }

    public function testGenerateReusableHash()
    {
        $dependency = $this->getMockForAbstractClass(Dependency::class);
        $dependency->data = 'dummy';

        $result = $this->invokeMethod($dependency, 'generateReusableHash');
        $this->assertEquals(5, strlen($dependency->data));
        $this->assertEquals(40, strlen($result));
    }

    public function testIsChanged()
    {
        /* @var $dependency Dependency */
        /* @var $cache SimpleCache */
        $dependency = $this->getMockForAbstractClass(Dependency::class);
        $cache = $this->getMockForAbstractClass(SimpleCache::class);

        $result = $dependency->isChanged($cache);
        $this->assertFalse($result);

        $dependency->data = 'changed';
        $result = $dependency->isChanged($cache);
        $this->assertTrue($result);
    }
}
