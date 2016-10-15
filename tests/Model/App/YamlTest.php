<?php
namespace Test\Model\App;

use App\Yaml;
use Test\Mock\MockTest;

class YamlTest extends \PHPUnit_Framework_TestCase
{

    /**
     *
     * @var Yaml
     */
    private $yaml = null;

    public function setUp()
    {
        $this->yaml = new Yaml();
    }

    public function testConstructor()
    {
        $this->assertInstanceOf(
            'Symfony\Component\Yaml\Parser',
            \PHPUnit_Framework_Assert::readAttribute(
                $this->yaml,
                'parser'
            )
        );
    }

    /**
     * @expectedException \RuntimeException
     */
    public function testFileIsNotReadable()
    {
        $file = MockTest::mockFile('noReadableFile.yml', 0000);
        $this->yaml->parse($file);
    }

    /**
     * @expectedException \RuntimeException
     */
    public function testFileNotExists()
    {
        $file = 'noExistingFile.yml';
        $this->yaml->parse($file);
    }

    public function testChangeToArray()
    {
        $stub = \Mockery::mock('Parser');
        $stub->shouldReceive('parse')->andReturn([])->once();
        MockTest::inject($this->yaml, 'parser', $stub);
        MockTest::callMockMethod(
            $this->yaml,
            'changeToArray',
            [MockTest::mockFile('readableYamlFile.yml')]
        );
    }

    public function testSaveArrayToFile()
    {
        MockTest::inject($this->yaml, 'tmpDir');
        $file = MockTest::mockFile('anyFile.php');
        MockTest::callMockMethod(
            $this->yaml,
            'saveArrayToFile',
            [$file, ['anyArray']]
        );
        $this->assertEquals(['anyArray'], include $file);
    }

    public function testReadFromTmpFile()
    {
        $yamlFile = MockTest::mockFile('anyFile.yml');
        $structure = MockTest::mockFileSystem([
            md5($yamlFile) . '.php' => "<?php return ['anyArray'];"
        ]);
        MockTest::inject($this->yaml, 'tmpDir', $structure);
        $this->assertEquals(['anyArray'], $this->yaml->parse($yamlFile));
    }

    public function testReadFromYaml()
    {
        $yamlFile = MockTest::mockFile('anyYamlFile.yml', 0644, 'any: content');
        $this->assertEquals(['any' => 'content'], $this->yaml->parse($yamlFile));
    }
}
