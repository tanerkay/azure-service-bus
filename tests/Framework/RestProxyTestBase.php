<?php

/**
 * LICENSE: Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 * http://www.apache.org/licenses/LICENSE-2.0.
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 *
 * PHP version 5
 *
 * @category  Microsoft
 *
 * @author    Azure PHP SDK <azurephpsdk@microsoft.com>
 * @copyright 2012 Microsoft Corporation
 * @license   http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 *
 * @link      https://github.com/windowsazure/azure-sdk-for-php
 */

namespace Tests\Framework;


use AzureServiceBus\Common\Internal\Logger;
use AzureServiceBus\Common\Internal\Serialization\XmlSerializer;
use AzureServiceBus\Common\Internal\Utilities;
use AzureServiceBus\Common\ServicesBuilder;
use PHPUnit\Framework\TestCase;

/**
 * Test base for all REST proxy tests.
 *
 * @category  Microsoft
 *
 * @author    Azure PHP SDK <azurephpsdk@microsoft.com>
 * @copyright 2012 Microsoft Corporation
 * @license   http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 *
 * @version   Release: 0.5.0_2016-11
 *
 * @link      https://github.com/windowsazure/azure-sdk-for-php
 */
class RestProxyTestBase extends TestCase
{
    protected $restProxy;
    protected $xmlSerializer;
    protected $builder;

    public function setUp(): void {
        $this->xmlSerializer = new XmlSerializer();
        $this->builder = new ServicesBuilder();
        Logger::setLogFile('C:\log.txt');

        // Enable PHP asserts
        assert_options(ASSERT_ACTIVE, 1);
        assert_options(ASSERT_WARNING, 0);
        assert_options(ASSERT_QUIET_EVAL, 1);
        assert_options(ASSERT_CALLBACK, 'Tests\Framework\RestProxyTestBase::assertHandler');

    }

    protected function getTestName()
    {
        return sprintf('onesdkphp%04x', Utilities::generateRandomInt(0, 65535));
    }

    public static function assertHandler($file, $line, $code)
    {
        echo "Assertion Failed:\n
            File '$file'\n
            Line '$line'\n
            Code '$code'\n";
    }

    public function setProxy($serviceRestProxy)
    {
        $this->restProxy = $serviceRestProxy;
    }

    protected function onNotSuccessfulTest(\Throwable $t): void
    {
        parent::onNotSuccessfulTest($t);

        $this->tearDown();
        throw $t;
    }

    public function testDummy()
    {
        // dummy test to get rid of warning "No tests found in class 'Tests\Framework\RestProxyTestBase' "
    }
}
