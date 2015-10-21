<?php

namespace DoctrineMongoHydrator;

use Doctrine\ODM\MongoDB\DocumentManager;
use Doctrine\ODM\MongoDB\Mapping\ClassMetadata;
use Doctrine\ODM\MongoDB\Hydrator\HydratorInterface;
use Doctrine\ODM\MongoDB\UnitOfWork;

/**
 * THIS CLASS WAS GENERATED BY THE DOCTRINE ODM. DO NOT EDIT THIS FILE.
 */
class UserDocumentCmsUserHydrator implements HydratorInterface
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
        if (isset($data['loginName'])) {
            $value = $data['loginName'];
            $return = (string) $value;
            $this->class->reflFields['loginName']->setValue($document, $return);
            $hydratedData['loginName'] = $return;
        }

        /** @Field(type="string") */
        if (isset($data['password'])) {
            $value = $data['password'];
            $return = (string) $value;
            $this->class->reflFields['password']->setValue($document, $return);
            $hydratedData['password'] = $return;
        }

        /** @Field(type="string") */
        if (isset($data['avatar'])) {
            $value = $data['avatar'];
            $return = (string) $value;
            $this->class->reflFields['avatar']->setValue($document, $return);
            $hydratedData['avatar'] = $return;
        }

        /** @Field(type="string") */
        if (isset($data['userGroup'])) {
            $value = $data['userGroup'];
            $return = (string) $value;
            $this->class->reflFields['userGroup']->setValue($document, $return);
            $hydratedData['userGroup'] = $return;
        }

        /** @Field(type="string") */
        if (isset($data['status'])) {
            $value = $data['status'];
            $return = (string) $value;
            $this->class->reflFields['status']->setValue($document, $return);
            $hydratedData['status'] = $return;
        }

        /** @Field(type="string") */
        if (isset($data['birthday'])) {
            $value = $data['birthday'];
            $return = (string) $value;
            $this->class->reflFields['birthday']->setValue($document, $return);
            $hydratedData['birthday'] = $return;
        }

        /** @Field(type="string") */
        if (isset($data['address'])) {
            $value = $data['address'];
            $return = (string) $value;
            $this->class->reflFields['address']->setValue($document, $return);
            $hydratedData['address'] = $return;
        }

        /** @Field(type="string") */
        if (isset($data['province'])) {
            $value = $data['province'];
            $return = (string) $value;
            $this->class->reflFields['province']->setValue($document, $return);
            $hydratedData['province'] = $return;
        }

        /** @Field(type="string") */
        if (isset($data['city'])) {
            $value = $data['city'];
            $return = (string) $value;
            $this->class->reflFields['city']->setValue($document, $return);
            $hydratedData['city'] = $return;
        }

        /** @Field(type="string") */
        if (isset($data['county'])) {
            $value = $data['county'];
            $return = (string) $value;
            $this->class->reflFields['county']->setValue($document, $return);
            $hydratedData['county'] = $return;
        }

        /** @Field(type="string") */
        if (isset($data['detailedAddress'])) {
            $value = $data['detailedAddress'];
            $return = (string) $value;
            $this->class->reflFields['detailedAddress']->setValue($document, $return);
            $hydratedData['detailedAddress'] = $return;
        }

        /** @Field(type="string") */
        if (isset($data['tel'])) {
            $value = $data['tel'];
            $return = (string) $value;
            $this->class->reflFields['tel']->setValue($document, $return);
            $hydratedData['tel'] = $return;
        }

        /** @Field(type="string") */
        if (isset($data['sex'])) {
            $value = $data['sex'];
            $return = (string) $value;
            $this->class->reflFields['sex']->setValue($document, $return);
            $hydratedData['sex'] = $return;
        }

        /** @Field(type="hash") */
        if (isset($data['link'])) {
            $value = $data['link'];
            $return = $value;
            $this->class->reflFields['link']->setValue($document, $return);
            $hydratedData['link'] = $return;
        }

        /** @Field(type="hash") */
        if (isset($data['data'])) {
            $value = $data['data'];
            $return = $value;
            $this->class->reflFields['data']->setValue($document, $return);
            $hydratedData['data'] = $return;
        }

        /** @Field(type="date") */
        if (isset($data['created'])) {
            $value = $data['created'];
            if ($value === null) { $return = null; } else { $return = \Doctrine\ODM\MongoDB\Types\DateType::getDateTime($value); }
            $this->class->reflFields['created']->setValue($document, clone $return);
            $hydratedData['created'] = $return;
        }
        return $hydratedData;
    }
}