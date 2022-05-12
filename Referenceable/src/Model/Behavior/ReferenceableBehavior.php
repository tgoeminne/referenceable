<?php 

namespace Referencable\Model\Behavior;

use ArrayObject;
use Cake\Datasource\EntityInterface;
use Cake\Event\Event;
use Cake\ORM\Behavior;
use Cake\ORM\Entity;
use Cake\ORM\Query;

class ReferenceableBehavior extends Behavior
{
    protected $_defaultConfig = [
        'field' => 'reference',
        'implementedFinders' => ['translations' => 'findTranslations'],
    ];
    
    public function reference(EntityInterface $entity)
    {
        $config = $this->config();
        $field = $config['field'];
        $value = $this->generate($field);
        $entity->set($field, $value);
        $entity->setDirty($field, true);
    }
    
    public function generate($field)
    {
        $chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $letters = substr(str_shuffle($chars),0,2);
        $numbers = rand(111111,999999);
        
        $reference = $letters.$numbers;
        
        $exists = $this->_table->find('all')->where([$field => $reference])->toArray();
        
        if(count($exists) > 0){
            $reference = $this->reference();
        }else{
            return $reference;
        }
    }
    
    public function beforeSave(Event $event, EntityInterface $entity, ArrayObject $options)
    {
        if($entity->isNew()){
            $this->reference($entity);
        }
    }
    
    public function findReference(Query $query, array $options)
    {
        return $query->where(['reference' => $options['reference']]);
    }
    
}