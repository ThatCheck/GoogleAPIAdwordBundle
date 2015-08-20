<?php

/**
 * Created by PhpStorm.
 * User: admin_000
 * Date: 19/08/2015
 * Time: 11:21.
 */

namespace Thatcheck\Bundle\GoogleAPIAdwordBundle\Services;

/**
 * Class GoogleAPIAdwordAdGroupCriterionService.
 */
class GoogleAPIAdwordAdGroupCriterionService extends AbstractServiceManagement
{
    const ADD = 'ADD';
    const UPDATE = 'SET';
    const REMOVE = 'REMOVE';

    /**
     * @var array
     */
    private $operations;

    /**
     * @param $client
     */
    public function __construct($client)
    {
        parent::__construct($client);
        $this->operations = array();
    }
    /**
     * @return \SoapClient
     */
    public function getAdGroupCriterionService()
    {
        return $this->getService('AdGroupCriterionService');
    }

    /**
     * @param \AdGroupCriterion $criterion
     */
    public function createAndAdd(\AdGroupCriterion $criterion, $operator)
    {
        $operation = new \AdGroupCriterionOperation();
        $operation->operand = $criterion;
        $operation->operator = $operator;
        $this->add($operation);
    }

    /**
     * @param \AdGroupCriterionOperation $data
     */
    public function add(\AdGroupCriterionOperation $data)
    {
        if (!array_key_exists($data->operand->adGroupId, $this->operations)) {
            $this->operations[$data->operand->adGroupId] = array();
        }
        $this->operations[$data->operand->adGroupId][] = $data;
    }

    /**
     * @return mixed
     */
    public function mutate()
    {
        $data = array();
        foreach ($this->operations as $ope) {
            $data[] = $this->getAdGroupCriterionService()->mutate($ope);
        }

        return $data;
    }

    /**
     * @return array
     */
    public function getOperations()
    {
        return $this->operations;
    }
}
