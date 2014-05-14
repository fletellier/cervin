<?php

namespace Application\Library;

use \Doctrine\ORM\Event\LoadClassMetadataEventArgs;

//error_reporting(E_ALL ^ E_NOTICE);

class TablePrefix implements \Doctrine\Common\EventSubscriber
{
    protected $prefix = '';

    public function __construct($prefix = null)
    {
        if( isset($prefix) && !empty($prefix) ){
            $this->prefix = (string) $prefix;
        } elseif( defined(PREFIX) ){
            $this->prefix = (string) PREFIX;
        } else {
            $this->prefix = '';
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getSubscribedEvents()
    {
        return array(
            'loadClassMetadata'
        );
    }

    public function loadClassMetadata(LoadClassMetadataEventArgs $eventArgs)
    {
        $classMetadata = $eventArgs->getClassMetadata();
        $classMetadata->setTableName($this->prefix . $classMetadata->getTableName());
        foreach ($classMetadata->getAssociationMappings() as $fieldName => $mapping) {
            if ($mapping['type'] == \Doctrine\ORM\Mapping\ClassMetadataInfo::MANY_TO_MANY && isset($classMetadata->associationMappings[$fieldName]['joinTable']['name'])) {
                $mappedTableName = $classMetadata->associationMappings[$fieldName]['joinTable']['name'];
                $classMetadata->associationMappings[$fieldName]['joinTable']['name'] = $this->prefix . $mappedTableName;
            }
        }
    }

}
