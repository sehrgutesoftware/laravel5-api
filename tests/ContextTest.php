<?php

namespace Tests;

use SehrGut\Laravel5_Api\Context;

class ContextTest extends TestCase
{
    public function test_it_stores_and_returns_properties()
    {
        $context = new Context([
            'model'      => 'MODEL',
            'request'    => 'REQUEST',
            'input'      => 'INPUT',
            'action'     => 'ACTION',
            'query'      => 'QUERY',
            'resource'   => 'RESOURCE',
            'collection' => 'COLLECTION',
            'response'   => 'RESPONSE',
        ]);

        $this->assertEquals('MODEL', $context->model);
        $this->assertEquals('REQUEST', $context->request);
        $this->assertEquals('INPUT', $context->input);
        $this->assertEquals('ACTION', $context->action);
        $this->assertEquals('QUERY', $context->query);
        $this->assertEquals('RESOURCE', $context->resource);
        $this->assertEquals('COLLECTION', $context->collection);
        $this->assertEquals('RESPONSE', $context->response);
    }

    public function test_it_updates_properties()
    {
        $context = new Context([
            'query' => 'QUERY',
        ]);

        $this->assertEquals('QUERY', $context->query);

        $context->query = 'CURRY';

        $this->assertEquals('CURRY', $context->query);
    }

    public function test_it_protects_read_only_properties()
    {
        $context = new Context([
            'model' => 'Keep it',
        ]);

        $this->assertEquals('Keep it', $context->model);
        $context->model = 'Trollin around';
        $this->assertEquals('Keep it', $context->model);
    }

    public function test_it_stores_returns_and_updates_overloaded_properties()
    {
        $context = new Context([
            'rmadon_sritng' => 'RMADON_SRITNG',
            'anodda_one'    => 'ANODDA_ONE',
        ]);

        $this->assertEquals('RMADON_SRITNG', $context->rmadon_sritng);
        $this->assertEquals('ANODDA_ONE', $context->anodda_one);

        $context->rmadon_sritng = 'GNTIRS_NODAMR';
        $context->anodda_one = 'ENO_ADDONA';

        $this->assertEquals('GNTIRS_NODAMR', $context->rmadon_sritng);
        $this->assertEquals('ENO_ADDONA', $context->anodda_one);
    }
}
