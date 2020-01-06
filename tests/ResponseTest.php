<?php

namespace Damonto\ResponseCaster\Tests;

use Damonto\ResponseCaster\ResponseCaster;
use Illuminate\Http\Resources\Json\Resource;
use PHPUnit\Framework\TestCase as FrameworkTestCase;

class ResponseTest extends FrameworkTestCase
{
    use ResponseCaster;

    public function testCreated()
    {
        $created = $this->response()->created('/testing');

        $this->assertEquals($created->headers->get('location'), '/testing');
        $this->assertEquals($created->getStatusCode(), 201);
        $this->assertEquals($created->getContent(), '{"status":true,"status_code":201,"message":null}');
    }

    public function testItem()
    {
        $success = $this->response()->item([
            'fake' => 'fake-response'
        ]);

        $this->assertEquals($success->getStatusCode(), 200);
        $this->assertEquals($success->getContent(), '{"status":true,"status_code":200,"message":null,"data":{"fake":"fake-response"}}');
    }

    public function testResource()
    {
        $resource = new class(['fake-resource']) extends Resource {};
        $response = $this->response()->resource($resource);

        $this->assertArrayHasKey('status_code', $response->with);
        $this->assertArrayHasKey('status', $response->with);
        $this->assertArrayHasKey('message', $response->with);
    }
}
