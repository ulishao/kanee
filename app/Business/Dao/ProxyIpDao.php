<?php

namespace App\Http\Business\Dao;

use App\Exceptions\JsonException;

class ProxyIpDao
{
    /**
     * 代理IP 模型申明
     *
     * @var
     */
    private $proxy_ip_model;

    /**
     *
     * ProxyIpDao constructor.
     */
    public function __construct()
    {
        $this->proxy_ip_model = app( 'ProxyIpModel' );
    }

    /**
     * 获取代理IP列表
     *
     * @param array $condition
     * @param array $columns
     * @param array $relatives
     * @return mixed
     * @author jiangxianli
     * @created_at 2017-12-25 10:33:56
     */
    public function getProxyIpList( $condition = [] , $columns = [ '*' ] , $relatives = [] )
    {
        $proxy_ip = app( 'ProxyIpModel' )->select( $columns );
        if ( isset( $condition['order_by'] ) && isset( $condition['order_rule'] ) ) {
            $proxy_ip->orderBy( $condition['order_by'] , $condition['order_rule'] );
        }
        if ( isset( $condition['all'] ) && $condition['all'] == 'true' ) {
            $proxy_ip = $proxy_ip->get();
        }
        else if ( isset( $condition['first'] ) && $condition['first'] == 'true' ) {
            $proxy_ip = $proxy_ip->first();
        }
        else {
            $page_size = array_get( $condition , 'page_size' , 15 );
            $proxy_ip  = $proxy_ip->paginate( $page_size );
        }
        if ( !empty( $relatives ) ) {
            $proxy_ip = $proxy_ip->load( $relatives );
        }
        return $proxy_ip;
    }

    /**
     * 添加代理IP
     *
     * @param array $ip_data
     * @return \Laravel\Lumen\Application|mixed
     * @throws JsonException
     * @author jiangxianli
     * @created_at 2017-12-22 16:15:18
     */
    public function addProxyIp( array $ip_data = [] )
    {
        $rule      = [ 'unique_id'    => [ 'required' ] , 'ip' => [ 'required' ] , 'port' => [ 'required' , 'integer' ] , 'anonymity' => [ 'required' , 'integer' ] , 'protocol' => [ 'required' , 'in:http,https' ] , 'speed' => [ 'required' ] , //            'isp'          => ['required'],
                       'validated_at' => [ 'required' ] , ];
        $validator = app( 'validator' )->make( $ip_data , $rule );
        if ( $validator->fails() ) {
            throw new JsonException( 10000 , $validator->messages() );
        }
        $proxy_ip = app( 'ProxyIpModel' );
        $proxy_ip->fill( $ip_data );
        $proxy_ip->save();
        return $proxy_ip;
    }

    /**
     * 更新代理IP
     *
     * @param $unique_id
     * @param array $ip_data
     * @return mixed
     * @throws JsonException
     * @author jiangxianli
     * @created_at 2017-12-22 16:18:15
     */
    public function updateProxyIp( $unique_id , array $ip_data = [] )
    {
        $rule      = [ 'speed' => [ 'sometimes' ] , 'validated_at' => [ 'sometimes' ] , ];
        $validator = app( 'validator' )->make( $ip_data , $rule );
        if ( $validator->fails() ) {
            throw new JsonException( 10000 , $validator->messages() );
        }
        $affect = app( 'ProxyIpModel' )->where( 'unique_id' , $unique_id )->update( $ip_data );
        return $affect;
    }

    /**
     * 删除代理IP
     *
     * @param $unique_id
     * @return mixed
     * @throws JsonException
     * @author jiangxianli
     * @created_at 2017-12-22 16:19:43
     */
    public function deleteProxyIp( $unique_id )
    {
        if ( empty( $unique_id ) ) {
            throw new JsonException( 10000 );
        }
        $affect = app( 'ProxyIpModel' )->where( 'unique_id' , $unique_id )->delete();
        return $affect;
    }

    /**
     * 查询唯一性 代理Ip
     *
     * @param $ip
     * @param $port
     * @param $protocol
     * @return mixed
     * @author jiangxianli
     * @created_at 2017-12-22 16:27:15
     */
    public function findUniqueProxyIp( $ip , $port , $protocol )
    {
        $proxy_ip = app( 'ProxyIpModel' )->where( 'ip' , $ip )->where( 'port' , $port )->where( 'protocol' , $protocol )->first();
        return $proxy_ip;
    }

    /**
     * 所有没有定位的IP里诶博爱
     *
     * @return mixed
     * @author jiangxianli
     * @created_at 2017-12-27 09:31:50
     */
    public function allNoIpAddressProxyIp()
    {
        $proxy_ips = app( 'ProxyIpModel' )->where( 'ip_address' , '' )->orWhereNull( 'ip_address' )->get();
        return $proxy_ips;
    }
}