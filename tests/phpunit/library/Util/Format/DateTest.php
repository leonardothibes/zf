<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 nowrap: */
/**
 * @category Tests
 * @package Util
 * @subpackage Format
 * @author Leonardo C. Thibes <leonardothibes@yahoo.com.br>
 * @copyright Copyright (c) Os Autores
 * @version $Id: DateTest.php 16/11/2010 10:05:26 leonardo $
 */

require_once 'PHPUnit/Framework.php';
require_once dirname(dirname(dirname(dirname(__FILE__)))) . DIRECTORY_SEPARATOR . 'Bootstrap.php';

/**
 * @category Tests
 * @package Util
 * @subpackage Format
 * @author Leonardo C. Thibes <leonardothibes@yahoo.com.br>
 * @copyright Copyright (c) Os Autores
 */
class Util_Format_DateTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var Util_Format_Date
     */
    protected $object;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        $this->object = new Util_Format_Date;
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown()
    {
    	unset($this->object);
    }
    
	/**
     * Testa se a classe implementa a interface certa.
     */
    public function testInterface()
    {
    	$this->assertType('Util_Format_Interface', $this->object);
    }

    /**
     * Provider de datas válidas.
     * @return array
     */
    public function providerValid()
    {
    	return array(
    		array('01/08/1984'),
    		array('16/11/2010'),
    		array('29/02/2008'),
    	);
    }
    
    /**
     * Provider de datas inválidas.
     * @return array
     */
    public function providerInvalid()
    {
    	return array(
    		array('01/13/1984'),
    		array('32/11/2010'),
    		array('29/02/2009'),
    		array('31/11/2010'),
    		array('31/11/201'),
    		array('31/111/2010'),
    		array(true),
    		array(false),
    		array(null),
    	);
    }
	
    /**
     * Provider de anos.
     * @return array
     */
    public function providerYears()
    {
    	return array(
    		array(1, 2010, array(2010 => 2010, 2009 => 2009)),
    		array(2, 2010, array(2010 => 2010, 2009 => 2009, 2008 => 2008)),
    		array(1, 2009, array(2009 => 2009, 2008 => 2008)),
    		array(2, 2009, array(2009 => 2009, 2008 => 2008, 2007 => 2007)),
    	);
    }
    
    /**
     * Provider de ranges de anos.
     * @return array
     */
    public function providerRanges()
    {
    	return array(
    		array(2005, 2007, array(2007 => 2007, 2006 => 2006, 2005 => 2005)),
    		array(2008, 2010, array(2010 => 2010, 2009 => 2009, 2008 => 2008)),
    	);
    }
    
    /**
     * Provider de meses e anos.
     * @return array
     */
    public function providerMonthsYears()
    {
    	return array(
    		
    		//Ano de 2011.
    		array(1, 2011, 31),
    		array(2, 2011, 28),
    		array(3, 2011, 31),
    		array('01', 2011, 31),
    		array('02', 2011, 28),
    		array('03', 2011, 31),
    		array(10, 2011, 31),
    		array(11, 2011, 30),
    		array(12, 2011, 31),
    		
    		//Ano de 2012.
    		array(1, 2012, 31),
    		array(2, 2012, 29),
    		array(3, 2012, 31),
    		array('01', 2012, 31),
    		array('02', 2012, 29),
    		array('03', 2012, 31),
    		array(10, 2012, 31),
    		array(11, 2012, 30),
    		array(12, 2012, 31),
    	);
    }
    
    /**
     * Provider de meses.
     * @return array
     */
    public function providerMonths()
    {
    	return array(
    		array(1 , 'Janeiro'),
    		array(2 , 'Fevereiro'),
    		array(3 , 'Março'),
    		array(4 , 'Abril'),
    		array(5 , 'Maio'),
    		array(6 , 'Junho'),
    		array(7 , 'Julho'),
    		array(8 , 'Agosto'),
    		array(9 , 'Setembro'),
    		array(10, 'Outubro'),
    		array(11, 'Novembro'),
    		array(12, 'Dezembro'),
    		array(13, false),
    	);
    }
    
    /**
     * Testa a verificação de validade.
     * @dataProvider providerValid
     */
    public function testIsValid($card)
    {
        $rs = Util_Format_Date::isValid($card);
        $this->assertType('bool', $rs);
        $this->assertTrue($rs);
    }
    
	/**
     * Testa a verificação de validade.
     * @dataProvider providerInvalid
     */
    public function testIsInvalid($date = null)
    {
        $rs = Util_Format_Date::isValid($date);
        $this->assertType('bool', $rs);
        $this->assertFalse($rs);
    }
    
    /**
     * Testa a listagem de anos.
     * @dataProvider providerYears
     */
    public function testYearList($quantidade, $anoBase = null, $esperado)
    {
    	$rs = Util_Format_Date::YearList($quantidade, $anoBase);
    	
    	$this->assertType('array', $rs);
    	$this->assertGreaterThan(0, count($rs));
    	$this->assertEquals(serialize($esperado), serialize($rs));
    }
    
	/**
     * Testa o range de anos.
     * @dataProvider providerRanges
     */
    public function testYearRange($inicio, $fim, $esperado)
    {
    	$rs = Util_Format_Date::YearRange($inicio, $fim);
    	
    	$this->assertType('array', $rs);
    	$this->assertGreaterThan(0, count($rs));
    	$this->assertEquals(serialize($esperado), serialize($rs));
    }
    
    /**
     * Testa o cálculo de último dia do mês.
     * @dataProvider providerMonthsYears
     */
    public function testLastDay($mes, $ano, $esperado)
    {
    	$rs = Util_Format_Date::LastDay($mes, $ano);
    	$this->assertType('int', $rs);
    	$this->assertEquals($esperado, $rs);
    }
    
    /**
     * Testa a nome dos meses.
     * @dataProvider providerMonths
     */
    public function testMonthName($numero, $nome)
    {
    	$mes = Util_Format_Date::MonthName($numero);
    	$this->assertSame($nome, $mes);
    	
    	$mes = Util_Format_Date::MonthName($numero, true);
    	$this->assertSame(substr($nome,0,3), $mes);
    }
}
