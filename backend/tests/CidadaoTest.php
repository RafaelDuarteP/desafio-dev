<?php

require_once __DIR__ . '/../vendor/autoload.php';

use PHPUnit\Framework\TestCase;
require_once __DIR__ . '/../src/models/Cidadao.php';

class CidadaoTest extends TestCase
{
    public function testCidadao()
    {
        $cidadao = new Cidadao();
        $this->assertInstanceOf(Cidadao::class, $cidadao);
    }

    public function testGetNome()
    {
        $cidadao = new Cidadao();
        $cidadao->setNome('João');
        $this->assertEquals('João', $cidadao->getNome());
    }

    public function testGetNis()
    {
        $cidadao = new Cidadao();
        $cidadao->setNis('12345678901');
        $this->assertEquals('12345678901', $cidadao->getNis());
    }
    
    public function testToArray(){
        $cidadao = new Cidadao();
        $cidadao->setNome('João')->setNis('12345678901');
        $this->assertEquals(['nome' => 'João', 'nis' => '12345678901'], $cidadao->toArray());
    }

    public function testCreateNisValido(){
        $cidadao = new Cidadao();
        $nis = $cidadao->createNis();
        $this->assertEquals(11, strlen($nis));
        $this->assertMatchesRegularExpression('/[0-9]{11}/', $nis);
    }

    public function testCreateNisUnico(){
        $cidadao = new Cidadao();
        $nis1 = $cidadao->createNis();
        $nis2 = $cidadao->createNis();
        $this->assertNotEquals($nis1, $nis2);
    }


}