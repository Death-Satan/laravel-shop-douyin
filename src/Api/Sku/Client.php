<?php declare(strict_types=1);

/*
 * This file is part of the xbhub/ShopDouyin.
 *
 * (c) jory <jorycn@163.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Xbhub\ShopDouyin\Api\Sku;

use Xbhub\ShopDouyin\Api\Kernel\BaseClient;

/**
 * Class Client.
 *
 * @author jory <jorycn@163.com>
 */
class Client extends BaseClient
{

   /**
    * 添加sku
    *
    * @param string $product_id
    * @param string $out_sku_id 业务方自己的sku_id,唯一 (需为数字字符串, max = int64)
    * @param string $spec_id 规格id
    * @param string $spec_detail_ids 子规格id,最多3级,如100041|150041|160041 例如 女款|白色|XL
    * @param string $stock_num 库存 (必须大于0)
    * @param string $price 售价 (单位 分)
    * @param string $settlement_price 结算价格 (单位 分)
    * @return void
    */
    public function add(...$options)
    {
        return $this->httpPost('sku.add', $this->_mergeBaseArgs($options));
    }

    /**
     * 批量添加sku
     *
     * @param string $product_id
     * @param string $out_sku_id
     * @param string $spec_id
     * @param string $spec_detail_ids
     * @param string $stock_num
     * @param string $price
     * @param string $settlement_price
     * @return void
     */
    public function addAll(array $options)
    {
        return $this->httpPost('sku.addAll', $options);
    }

    /**
     * 获取sku列表
     *
     * @param string $product_id product_id|out_product_id
     * @return array
     */
    public function list(string $product_id)
    {
        return $this->httpPost('sku.list', compact('product_id'));
    }


    /**
     * 编辑sku价格
     *
     * @param array $id sku_id
     * @param array $sku_id out_sku_id|sku_id
     * @param string $price
     * @return void
     */
    public function editPrice(string $id, string $sku_id, string $price,array $options=[])
    {
        return $this->httpPost('sku.editPrice', array_merge($id, [
            'price' => $price
        ]));
    }

    /**
     * 删除sku
     * @param string $id
     * @param array $options
     * @return array
     * @throws \Xbhub\ShopDouyin\Api\Kernel\Exceptions\ClientError
     */
    public function del(string $id,array $options=[])
    {
        return $this->httpPost('sku.del',array_merge(compact('id'),$options));
    }



}
