<?php

namespace Tests;

use SoerBot\Configurator;
use Symfony\Component\Yaml\Yaml;
use SoerBot\Exceptions\ConfigurationFileNotFound;

/**
 * Test case for Configurator class.
 *
 * @package Tests
 */
class ConfiguratorTest extends TestCase
{
    /**
     * Check default path to configs.
     */
    public function testGetDefaultPath()
    {
        $this->assertEquals(
            realpath(__DIR__ . '/../config.yaml'),
            realpath(Configurator::getConfigPath())
        );
    }

    /**
     * Set path to configs.
     */
    public function testSetConfigPath()
    {
        $pathToStubConfig = realpath(__DIR__ . '/Fixtures/config.stub.yaml');
        Configurator::setConfigPath($pathToStubConfig);

        $this->assertEquals($pathToStubConfig, Configurator::getConfigPath());
    }

    /**
     * Get exists key from configs.
     */
    public function testGetExistsKey()
    {
        $pathToStubConfig = realpath(__DIR__ . '/Fixtures/config.stub.yaml');
        Configurator::setConfigPath($pathToStubConfig);

        $this->assertEquals('bar', Configurator::get('foo'));
    }

    /**
     * Get default value for not exists key from configs.
     */
    public function testGetNotExistsKey()
    {
        $pathToStubConfig = realpath(__DIR__ . '/Fixtures/config.stub.yaml');
        Configurator::setConfigPath($pathToStubConfig);

        $this->assertNull(Configurator::get('baz'));
        $this->assertEquals('default', Configurator::get('baz', 'default'));
    }

    /**
     * Get default value for not empty key from configs.
     */
    public function testGetEmptyKey()
    {
        $pathToStubConfig = realpath(__DIR__ . '/Fixtures/config.stub.yaml');
        Configurator::setConfigPath($pathToStubConfig);

        $this->assertNull(Configurator::get(''));
        $this->assertEquals('default', Configurator::get('', 'default'));
    }

    /**
     * Test nested keys.
     */
    public function testGetNestedKeys()
    {
        $pathToStubConfig = realpath(__DIR__ . '/Fixtures/config.stub.yaml');
        Configurator::setConfigPath($pathToStubConfig);
        $this->assertArrayHasKey('branch', Configurator::get('ci'));
    }

    /**
     * Test nested keys access via dot notation.
     */
    public function testDotNotationGetRightValue()
    {
        $pathToStubConfig = realpath(__DIR__ . '/Fixtures/config.stub.yaml');
        Configurator::setConfigPath($pathToStubConfig);

        $this->assertEquals('develop', Configurator::get('ci.branch'));
    }

    /**
     * Test non exist nested key access via dot notation.
     */
    public function testDotNotationGetNonExistsValue()
    {
        $pathToStubConfig = realpath(__DIR__ . '/Fixtures/config.stub.yaml');
        Configurator::setConfigPath($pathToStubConfig);

        $this->assertNull(Configurator::get('ci.baz'));
        $this->assertEquals('default', Configurator::get('ci.baz', 'default'));
    }

    /**
     * Load configs from file.
     */
    public function testLoadConfig()
    {
        $pathToStubConfig = realpath(__DIR__ . '/Fixtures/config.stub.yaml');
        Configurator::setConfigPath($pathToStubConfig);

        $this->assertNull(Configurator::get('baz'));
        $this->assertEquals(Yaml::parseFile($pathToStubConfig), Configurator::all());
    }

    /**
     * Throw exception.
     *
     * @expected ConfigurationFileNotFound
     */
    public function testThrowExceptionIfConfigFileNotFound()
    {
        $this->expectException(ConfigurationFileNotFound::class);
        Configurator::setConfigPath('');

        Configurator::load();
    }
}
