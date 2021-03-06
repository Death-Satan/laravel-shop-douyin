<?php

/*
 * This file is part of the xbhub/ShopDouyin.
 *
 * (c) jory <jorycn@163.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Xbhub\ShopDouyin\Api\Kernel;

use Illuminate\Support\Facades\Log;
use GuzzleHttp\Exception\RequestException;

/**
 * Trait MakesHttpRequests.
 *
 * @author jory <jorycn@163.com>
 */
trait MakesHttpRequests
{
    /**
     * @var bool
     */
    protected $transform = true;

    protected $Closure='';

    /**
     * @param string $method
     * @param string $uri
     * @param array $options
     * @return array
     * @throws Exceptions\ClientError
     */
    public function request(string $method, string $uri, array $options = [])
    {
        try {
            $response = $this->app['http_client']->request($method, $uri, $options);
            return $this->transform ? $this->transformResponse($response) : $response;
        } catch (RequestException $e) {
            throw new Exceptions\ClientError('request error');
        }
    }

    /**
     * @return $this
     */
    public function dontTransform()
    {
        $this->transform = false;

        return $this;
    }


    /**
     * @param $response
     * @return array
     * @throws Exceptions\ClientError
     */
    protected function transformResponse($response)
    {
        $result = json_decode($response->getBody()->getContents(), true);
        if (json_last_error()){
            ApiReturn(40002,'json_decode errors'.json_last_error_msg());
        }
        if ($result['err_no'] && !in_array($result['err_no'], [0, 200000])) {
            // throw new Exceptions\ClientError($result['errmsg'], $result['errcode']);
            ApiReturn(40002,$result['message']);
        }
        return $result;
    }
}
