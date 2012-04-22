<?php

/**
 * PluginaPollPollTable
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class PluginaPollPollTable extends Doctrine_Table
{
    /**
     * Returns an instance of this class.
     *
     * @return object PluginaPollPollTable
     */
    public static function getInstance()
    {
        return Doctrine_Core::getTable('PluginaPollPoll');
    }
    
    
    public function getByIdWithAnswers($params) {
        
        
        $q = $this->getInstance()->createQuery('p')
                ->addWhere('p.id = ?',$params['id'])
                ->leftJoin('p.Answers a')
                ->leftJoin('a.Fields f');
        
        return $q->execute();
        
    }
    
}