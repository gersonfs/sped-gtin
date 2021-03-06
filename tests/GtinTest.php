<?php

namespace NFePHP\Gtin\Tests;

use NFePHP\Gtin\Gtin;
use PHPUnit\Framework\TestCase;

class GtinTest extends TestCase
{
    /**
     * @covers Gtin::getPrefix
     * @covers Gtin::getType
     * @covers Gtin::getPrefixRegion
     * @covers Gtin::getCheckDigit
     * @covers Gtin::__contruct
     */
    public function testCanInstantiate()
    {
        $gtin = new Gtin('78935761');
        $this->assertInstanceOf('NFePHP\Gtin\Gtin', $gtin);
    }
    
    /**
     * @covers Gtin::getPrefix
     * @covers Gtin::getType
     * @covers Gtin::getPrefixRegion
     * @covers Gtin::getCheckDigit
     * @covers Gtin::__contruct
     * @covers Gtin::check
     */
    public function testCanInstantiateStatic()
    {
        $gtin = Gtin::check('78935761');
        $this->assertInstanceOf('NFePHP\Gtin\Gtin', $gtin);
    }

    /**
     * @covers Gtin::getPrefixRegion
     */
    public function testRegion()
    {
        $gtin = new Gtin('78935761');
        $this->assertEquals('GS1 Brasil', $gtin->region);
        
        $region = Gtin::check('78935761')->region;
        $this->assertEquals('GS1 Brasil', $region);
    }
    
    /**
     * @covers Gtin::getCheckDigit
     */
    public function testCheckDigit()
    {
        $gtin = new Gtin('78935761');
        $this->assertEquals(1, $gtin->checkDigit);
        
        $dv = Gtin::check('78935761')->checkDigit;
        $this->assertEquals(1, $dv);
    }
    
    /**
     * @covers Gtin::getPrefix
     * @covers Gtin::getType
     */
    public function testPrefix()
    {
        $gtin = new Gtin('78935761');
        $this->assertEquals('789', $gtin->prefix);
        
        $prefix = Gtin::check('78935761')->prefix;
        $this->assertEquals('789', $prefix);
    }
    
    public function testIsValid()
    {
        $gtin = new Gtin('78935761');
        $this->assertTrue($gtin->isValid());
        
        $resp = Gtin::check('78935761')->isValid();
        $this->assertTrue($resp);
    }
    
    /**
     *  @expectedException \InvalidArgumentException
     *  @expectedExceptionMessage Um GTIN deve ser passado para a classe.
     */
    public function testFailStringEmptyGtin()
    {
        $gtin = new Gtin('');
    }
    
    /**
     *  @expectedException \InvalidArgumentException
     *  @expectedExceptionMessage Um GTIN deve ser passado para a classe.
     */    
    public function testFailNullGtin()
    {
        $gtin = new Gtin(null);
    }
    
    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage GTIN deve conter apenas numeros.
     */
    public function testInvalidStringGtin()
    {
        $gtin = new Gtin('A12345');
    }
    
    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Apenas GTIN 8, 12, 13 ou 14 esse numero não atende esses parâmetros.
     */
    public function testInvalidMinLengthGtin()
    {
        $gtin = new Gtin('12345');
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Apenas GTIN 8, 12, 13 ou 14 esse numero não atende esses parâmetros.
     */
    public function testInvalidMaxLengthGtin()
    {
        $gtin = new Gtin('1234567890123456');
    }    
    
    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Apenas GTIN 8, 12, 13 ou 14 esse numero não atende esses parâmetros.
     */
    public function testInvalidLengthGtin()
    {
        $gtin = new Gtin('1234567890');
    }
    
    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage O prefixo 021 do GTIN é INVALIDO [Números de circulação restrita dentro da região].
     */
    public function testInvalidPrefixGtin()
    {
        $gtin = Gtin::check('0219907267612')->isValid();
    }
    
    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage O digito verificador é INVALIDO.
     */
    public function testInvalidCheckDigit()
    {
        $resp = Gtin::check('7890142547851')->isValid();
    }
    
    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Um GTIN 14 não pode iniciar com numeral ZERO.
     */
    public function testFailGtin14BeginsZero()
    {
        $resp = Gtin::check('07890142547852')->isValid();
    }
}