<?php

namespace DoctrineMongoHydrator;

use Doctrine\ODM\MongoDB\DocumentManager;
use Doctrine\ODM\MongoDB\Mapping\ClassMetadata;
use Doctrine\ODM\MongoDB\Hydrator\HydratorInterface;
use Doctrine\ODM\MongoDB\UnitOfWork;

/**
 * THIS CLASS WAS GENERATED BY THE DOCTRINE ODM. DO NOT EDIT THIS FILE.
 */
class PromotionDocumentPrizeHydrator implements HydratorInterface
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
        if (isset($data['name'])) {
            $value = $data['name'];
            $return = (string) $value;
            $this->class->reflFields['name']->setValue($document, $return);
            $hydratedData['name'] = $return;
        }

        /** @Field(type="string") */
        if (isset($data['type'])) {
            $value = $data['type'];
            $return = (string) $value;
            $this->class->reflFields['type']->setValue($document, $return);
            $hydratedData['type'] = $return;
        }

        /** @Field(type="int") */
        if (isset($data['quantity'])) {
            $value = $data['quantity'];
            $return = (int) $value;
            $this->class->reflFields['quantity']->setValue($document, $return);
            $hydratedData['quantity'] = $return;
        }

        /** @Field(type="int") */
        if (isset($data['remainderCounter'])) {
            $value = $data['remainderCounter'];
            $return = (int) $value;
            $this->class->reflFields['remainderCounter']->setValue($document, $return);
            $hydratedData['remainderCounter'] = $return;
        }

        /** @Field(type="int") */
        if (isset($data['promotionId'])) {
            $value = $data['promotionId'];
            $return = (int) $value;
            $this->class->reflFields['promotionId']->setValue($document, $return);
            $hydratedData['promotionId'] = $return;
        }
        return $hydratedData;
    }
}