<?php

/**
 * LICENSE: The MIT License (the "License")
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 * https://github.com/azure/azure-storage-php/LICENSE
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
 * @package   MicrosoftAzure\Storage\Tests\Unit\Blob\Models
 * @author    Azure Storage PHP SDK <dmsh@microsoft.com>
 * @copyright 2016 Microsoft Corporation
 * @license   https://github.com/azure/azure-storage-php/LICENSE
 * @link      https://github.com/azure/azure-storage-php
 */
namespace MicrosoftAzure\Storage\Tests\unit\Blob\Models;

use MicrosoftAzure\Storage\Blob\Models\ListBlobBlocksResult;
use MicrosoftAzure\Storage\Tests\Framework\TestResources;
use MicrosoftAzure\Storage\Common\Internal\Utilities;

/**
 * Unit tests for class ListBlobBlocksResult
 *
 * @category  Microsoft
 * @package   MicrosoftAzure\Storage\Tests\Unit\Blob\Models
 * @author    Azure Storage PHP SDK <dmsh@microsoft.com>
 * @copyright 2016 Microsoft Corporation
 * @license   https://github.com/azure/azure-storage-php/LICENSE
 * @version   Release: 0.12.1
 * @link      https://github.com/azure/azure-storage-php
 */
class ListBlobBlocksResultTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @covers MicrosoftAzure\Storage\Blob\Models\ListBlobBlocksResult::setLastModified
     * @covers MicrosoftAzure\Storage\Blob\Models\ListBlobBlocksResult::getLastModified
     * @covers MicrosoftAzure\Storage\Blob\Models\ListBlobBlocksResult::setETag
     * @covers MicrosoftAzure\Storage\Blob\Models\ListBlobBlocksResult::getETag
     * @covers MicrosoftAzure\Storage\Blob\Models\ListBlobBlocksResult::setContentType
     * @covers MicrosoftAzure\Storage\Blob\Models\ListBlobBlocksResult::getContentType
     * @covers MicrosoftAzure\Storage\Blob\Models\ListBlobBlocksResult::setContentLength
     * @covers MicrosoftAzure\Storage\Blob\Models\ListBlobBlocksResult::getContentLength
     * @covers MicrosoftAzure\Storage\Blob\Models\ListBlobBlocksResult::setUncommittedBlocks
     * @covers MicrosoftAzure\Storage\Blob\Models\ListBlobBlocksResult::getUncommittedBlocks
     * @covers MicrosoftAzure\Storage\Blob\Models\ListBlobBlocksResult::setCommittedBlocks
     * @covers MicrosoftAzure\Storage\Blob\Models\ListBlobBlocksResult::getCommittedBlocks
     * @covers MicrosoftAzure\Storage\Blob\Models\ListBlobBlocksResult::create
     */
    public function testCreate()
    {
        // Setup
        $sampleHeaders = TestResources::listBlocksMultipleEntriesHeaders();
        $sampleBody    = TestResources::listBlocksMultipleEntriesBody();
        $expectedDate = Utilities::rfc1123ToDateTime($sampleHeaders['Last-Modified']);
        $getEntry = self::getMethod('_getEntries');
        $uncommittedBlocks = $getEntry->invokeArgs(null, array($sampleBody, 'UncommittedBlocks'));
        $committedBlocks = $getEntry->invokeArgs(null, array($sampleBody, 'CommittedBlocks'));
        
        // Test
        $actual = ListBlobBlocksResult::create(
            $sampleHeaders,
            $sampleBody
        );
        
        // Assert
        $this->assertEquals($expectedDate, $actual->getLastModified());
        $this->assertEquals($sampleHeaders['Etag'], $actual->getETag());
        $this->assertEquals($sampleHeaders['Content-Type'], $actual->getContentType());
        $this->assertEquals($sampleHeaders['x-ms-blob-content-length'], $actual->getContentLength());
        $this->assertEquals($uncommittedBlocks, $actual->getUncommittedBlocks());
        $this->assertEquals($committedBlocks, $actual->getCommittedBlocks());
    }

    protected static function getMethod($name)
    {
        $class = new \ReflectionClass(new ListBlobBlocksResult());
        $method = $class->getMethod($name);
        $method->setAccessible(true);
        return $method;
    }
}
