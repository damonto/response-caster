<?php

namespace Damonto\ResponseCaster;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Response;

class Caster
{
    /**
     * Wrap response
     *
     * @param   bool    $status
     * @param   int     $statusCode
     * @param   null|string  $message
     *
     * @return array
     */
    protected function wrap(bool $status = true, int $statusCode = 200, ?string $message = '') : array
    {
        return [
            'status' => $status,
            'status_code' => $statusCode,
            'message' => $message
        ];
    }

    /**
     * Respond with a created response
     *
     * @param   string       $location
     * @param   null|string  $content
     *
     * @return  \Illuminate\Http\Response
     */
    public function created(string $location = null, ?string $content = null)
    {
        $response = (new Response)->setStatusCode(201)
            ->setContent($this->wrap(true, 201, $content));

        if (!is_null($location)) {
            $response->header('Location', $location);
        }

        return $response;
    }

    /**
     * Respond with an accepted response and associate a location and/or content if provided.
     *
     * @param null|string $location
     * @param mixed       $content
     *
     * @return  \Illuminate\Http\Response
     */
    public function accepted($location = null, $content = null)
    {
        $response = (new Response)->setStatusCode(202)
            ->setContent($this->wrap(true, 202, $content));

        if (!is_null($location)) {
            $response->header('Location', $location);
        }

        return $response;
    }

    /**
     * Respond with a no content response.
     *
     * @return \Illuminate\Http\Response
     */
    public function noContent()
    {
        return (new Response)->setStatusCode(204);
    }

    /**
     * Respond with a bad request response
     *
     * @param   string|null  $content
     *
     * @return  Response
     */
    public function badRequest(?string $content = null)
    {
        return (new Response)->setStatusCode(400)
            ->setContent($this->wrap(false, 400, $content));
    }

    /**
     * Respond with a unauthorization response
     *
     * @param   string|null  $content
     *
     * @return  \Illuminate\Http\Response
     */
    public function unauthorization(?string $content = null)
    {
        return (new Response)->setStatusCode(401)
            ->setContent($this->wrap(false, 401, $content));
    }

    /**
     * Respond with a forbidden response
     *
     * @param   string|null  $content
     *
     * @return  \Illuminate\Http\Response
     */
    public function forbidden(?string $content = null)
    {
        return (new Response)->setStatusCode(403)
            ->setContent($this->wrap(false, 403, $content));
    }

    /**
     * Respond with a not found response
     *
     * @param   string|null  $content
     *
     * @return  \Illuminate\Http\Response
     */
    public function notFound(?string $content = null)
    {
        return (new Response)->setStatusCode(404)
            ->setContent($this->wrap(false, 404, $content));
    }

    /**
     * Respond with an internal server error
     *
     * @param   string|null  $message
     * @param   string|null  $trace
     *
     * @return \Illuminate\Http\Response
     */
    public function internalServerError(?string $message = null, ?string $trace = null)
    {
        $response = (new Response)
            ->setStatusCode(500);

        $message = $this->wrap(false, 500, $message);
        if (app()->environment('development', 'testing') || config('app.debug')) {
            $message['trace'] = $trace;
        }

        return $response->setContent($message);
    }

    /**
     * Respond with an error response
     *
     * @param   int          $statusCode
     * @param   string|null  $message
     *
     * @return  \Illuminate\Http\Response
     */
    public function error(int $statusCode = 500, ?string $message = null, $content = null)
    {
        $data = $this->wrap(false, $statusCode, $message);
        $data['data'] = $content;

        return (new Response)->setStatusCode($statusCode)
            ->setContent($data);
    }

    /**
     * Respond with a success response
     *
     * @param   int          $statusCode
     * @param   string|null  $message
     *
     * @return  \Illuminate\Http\Response
     */
    public function success(int $statusCode = 200, ?string $message = null, $content = null)
    {
        return $this->item($content, $statusCode, $message);
    }

    /**
     * Respond with a JSON resource response
     *
     * @param   \Illuminate\Http\Resources\Json\JsonResource  $resource
     *
     * @return \Illuminate\Http\Resources\Json\JsonResource
     */
    public function resource(JsonResource $resource)
    {
        $resource->with = $this->wrap();

        return $resource;
    }

    /**
     * Respond with an item response
     *
     * @param   mixed        $item
     * @param   int          $statusCode
     * @param   string|null  $message
     *
     * @return  \Illuminate\Http\Response
     */
    public function item($item = null, int $statusCode = 200, ?string $message = null)
    {
        $data = $this->wrap(true, $statusCode, $message);
        $data['data'] = $item;

        return (new Response)->setStatusCode($statusCode)
            ->setContent($data);
    }
}
