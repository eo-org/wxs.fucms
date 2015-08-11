<?php

namespace DoctrineMongoHydrator;

use Doctrine\ODM\MongoDB\DocumentManager;
use Doctrine\ODM\MongoDB\Mapping\ClassMetadata;
use Doctrine\ODM\MongoDB\Hydrator\HydratorInterface;
use Doctrine\ODM\MongoDB\UnitOfWork;

/**
 * THIS CLASS WAS GENERATED BY THE DOCTRINE ODM. DO NOT EDIT THIS FILE.
 */
class WxDocumentPromotionSmashingHydrator implements HydratorInterface
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

        /** @Field(type="string") */
        if (isset($data['awardInfo'])) {
            $value = $data['awardInfo'];
            $return = (string) $value;
            $this->class->reflFields['awardInfo']->setValue($document, $return);
            $hydratedData['awardInfo'] = $return;
        }

        /** @Field(type="string") */
        if (isset($data['lotteryReply'])) {
            $value = $data['lotteryReply'];
            $return = (string) $value;
            $this->class->reflFields['lotteryReply']->setValue($document, $return);
            $hydratedData['lotteryReply'] = $return;
        }

        /** @Field(type="int_id") */
        if (isset($data['_id'])) {
            $value = $data['_id'];
            $return = (int) $value;
            $this->class->reflFields['id']->setValue($document, $return);
            $hydratedData['id'] = $return;
        }

        /** @Field(type="string") */
        if (isset($data['label'])) {
            $value = $data['label'];
            $return = (string) $value;
            $this->class->reflFields['label']->setValue($document, $return);
            $hydratedData['label'] = $return;
        }

        /** @Field(type="string") */
        if (isset($data['synopsis'])) {
            $value = $data['synopsis'];
            $return = (string) $value;
            $this->class->reflFields['synopsis']->setValue($document, $return);
            $hydratedData['synopsis'] = $return;
        }

        /** @Field(type="string") */
        if (isset($data['explain'])) {
            $value = $data['explain'];
            $return = (string) $value;
            $this->class->reflFields['explain']->setValue($document, $return);
            $hydratedData['explain'] = $return;
        }

        /** @Field(type="string") */
        if (isset($data['logo'])) {
            $value = $data['logo'];
            $return = (string) $value;
            $this->class->reflFields['logo']->setValue($document, $return);
            $hydratedData['logo'] = $return;
        }

        /** @Field(type="string") */
        if (isset($data['endExplain'])) {
            $value = $data['endExplain'];
            $return = (string) $value;
            $this->class->reflFields['endExplain']->setValue($document, $return);
            $hydratedData['endExplain'] = $return;
        }

        /** @Field(type="string") */
        if (isset($data['endLabel'])) {
            $value = $data['endLabel'];
            $return = (string) $value;
            $this->class->reflFields['endLabel']->setValue($document, $return);
            $hydratedData['endLabel'] = $return;
        }

        /** @Field(type="string") */
        if (isset($data['endImg'])) {
            $value = $data['endImg'];
            $return = (string) $value;
            $this->class->reflFields['endImg']->setValue($document, $return);
            $hydratedData['endImg'] = $return;
        }

        /** @Field(type="hash") */
        if (isset($data['prizes'])) {
            $value = $data['prizes'];
            $return = $value;
            $this->class->reflFields['prizes']->setValue($document, $return);
            $hydratedData['prizes'] = $return;
        }

        /** @Field(type="float") */
        if (isset($data['odds'])) {
            $value = $data['odds'];
            $return = (float) $value;
            $this->class->reflFields['odds']->setValue($document, $return);
            $hydratedData['odds'] = $return;
        }

        /** @Field(type="int") */
        if (isset($data['drawLimit'])) {
            $value = $data['drawLimit'];
            $return = (int) $value;
            $this->class->reflFields['drawLimit']->setValue($document, $return);
            $hydratedData['drawLimit'] = $return;
        }

        /** @Field(type="int") */
        if (isset($data['drawLimitDaily'])) {
            $value = $data['drawLimitDaily'];
            $return = (int) $value;
            $this->class->reflFields['drawLimitDaily']->setValue($document, $return);
            $hydratedData['drawLimitDaily'] = $return;
        }

        /** @Field(type="boolean") */
        if (isset($data['isActive'])) {
            $value = $data['isActive'];
            $return = (bool) $value;
            $this->class->reflFields['isActive']->setValue($document, $return);
            $hydratedData['isActive'] = $return;
        }

        /** @Field(type="date") */
        if (isset($data['startTime'])) {
            $value = $data['startTime'];
            if ($value === null) { $return = null; } else { $return = \Doctrine\ODM\MongoDB\Types\DateType::getDateTime($value); }
            $this->class->reflFields['startTime']->setValue($document, clone $return);
            $hydratedData['startTime'] = $return;
        }

        /** @Field(type="date") */
        if (isset($data['endTime'])) {
            $value = $data['endTime'];
            if ($value === null) { $return = null; } else { $return = \Doctrine\ODM\MongoDB\Types\DateType::getDateTime($value); }
            $this->class->reflFields['endTime']->setValue($document, clone $return);
            $hydratedData['endTime'] = $return;
        }
        return $hydratedData;
    }
}