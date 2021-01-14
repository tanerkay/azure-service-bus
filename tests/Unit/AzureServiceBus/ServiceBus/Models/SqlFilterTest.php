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
 * @link      https://github.com/WindowsAzure/azure-sdk-for-php
 */

namespace Tests\Unit\AzureServiceBus\ServiceBus\Models;

use AzureServiceBus\ServiceBus\Models\SqlFilter;

use PHPUnit\Framework\TestCase;

/**
 * Unit tests for class WrapAccessTokenResult.
 *
 * @category  Microsoft
 *
 * @author    Azure PHP SDK <azurephpsdk@microsoft.com>
 * @copyright 2012 Microsoft Corporation
 * @license   http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 *
 * @version   Release: 0.5.0_2016-11
 *
 * @link      https://github.com/WindowsAzure/azure-sdk-for-php
 */
class SqlFilterTest extends TestCase
{
    /**
     * @covers \AzureServiceBus\ServiceBus\Models\SqlFilter::__construct
     */
    public function testSqlFilterConstructor()
    {
        // Setup

        // Test
        $sqlFilter = new SqlFilter();

        // Assert
        $this->assertNotNull($sqlFilter);
    }

    /** 
     * @covers \AzureServiceBus\ServiceBus\Models\SqlFilter::getSqlExpression
     * @covers \AzureServiceBus\ServiceBus\Models\SqlFilter::setSqlExpression
     */
    public function testGetSetSqlExpression()
    {
        // Setup
        $expected = 'testSqlExpression';
        $sqlFilter = new SqlFilter();

        // Test
        $sqlFilter->setSqlExpression($expected);
        $actual = $sqlFilter->getSqlExpression();

        // Assert 
        $this->assertEquals(
            $expected,
            $actual
        );
    }

    /** 
     * @covers \AzureServiceBus\ServiceBus\Models\SqlFilter::getCompatibilityLevel
     * @covers \AzureServiceBus\ServiceBus\Models\SqlFilter::setCompatibilityLevel
     */
    public function testGetSetCompatibilityLevel()
    {
        // Setup
        $expected = 'testCompatibilityLevel';
        $filter = new SqlFilter();

        // Test
        $filter->setCompatibilityLevel($expected);
        $actual = $filter->getCompatibilityLevel();

        // Assert 
        $this->assertEquals(
            $expected,
            $actual
        );
    }
}
