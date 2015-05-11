<?php

namespace DoctrineMongoHydrator;

use Doctrine\ODM\MongoDB\DocumentManager;
use Doctrine\ODM\MongoDB\Mapping\ClassMetadata;
use Doctrine\ODM\MongoDB\Hydrator\HydratorInterface;
use Doctrine\ODM\MongoDB\UnitOfWork;

/**
 * THIS CLASS WAS GENERATED BY THE DOCTRINE ODM. DO NOT EDIT THIS FILE.
 */
class PromotionDocumentProbabilityCheckHydrator implements HydratorInterface
{
    private $dm;
    private $unitOfWork;
    private $class;

    public function __construct(DocumentManager $dm, UnitOfWork $uow, ClassMetadata $class)
    {
        $this->dm = $dm;
        $this->unitOfWork = $uow;
        $this->class = $class;
    }

    public function hydrate($document, $data, array $hints = array())
    {
        $hydratedData = array();

        /** @Field(type="id") */
        if (isset($data['_id'])) {
            $value = $data['_id'];
            $return = $value instanceof \MongoId ? (string) $value : $value;
            $this->class->reflFields['id']->setValue($document, $return);
            $hydratedData['id'] = $return;
        }

        /** @Field(type="string") */
        if (isset($data['openId'])) {
            $value = $data['openId'];
            $return = (string) $value;
            $this->class->reflFields['openId']->setValue($document, $return);
            $hydratedData['openId'] = $return;
        }

        /** @Field(type="string") */
        if (isset($data['promotionId'])) {
            $value = $data['promotionId'];
            $return = (string) $value;
            $this->class->reflFields['promotionId']->setValue($document, $return);
            $hydratedData['promotionId'] = $return;
        }

        /** @Field(type="string") */
        if (isset($data['promotionType'])) {
            $value = $data['promotionType'];
            $return = (string) $value;
            $this->class->reflFields['promotionType']->setValue($document, $return);
            $hydratedData['promotionType'] = $return;
        }

        /** @Field(type="string") */
        if (isset($data['sn'])) {
            $value = $data['sn'];
            $return = (string) $value;
            $this->class->reflFields['sn']->setValue($document, $return);
            $hydratedData['sn'] = $return;
        }

        /** @Field(type="boolean") */
        if (isset($data['result'])) {
            $value = $data['result'];
            $return = (bool) $value;
            $this->class->reflFields['result']->setValue($document, $return);
            $hydratedData['result'] = $return;
        }

        /** @Field(type="date") */
        if (isset($data['created'])) {
            $value = $data['created'];
            if ($value instanceof \MongoDate) { $date = new \DateTime(); $date->setTimestamp($value->sec); $return = $date; } else { $return = new \DateTime($value); }
            $this->class->reflFields['created']->setValue($document, clone $return);
            $hydratedData['created'] = $return;
        }
        return $hydratedData;
    }
}