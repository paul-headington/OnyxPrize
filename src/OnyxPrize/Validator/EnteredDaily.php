<?php

/*
 * Copyright (c) 2012 , Paul Headington
 * All rights reserved.
 * 
 * Redistribution and use in source and binary forms, with or without
 * modification, are permitted provided that the following conditions are met:
 * 1. Redistributions of source code must retain the above copyright
 *    notice, this list of conditions and the following disclaimer.
 * 2. Redistributions in binary form must reproduce the above copyright
 *    notice, this list of conditions and the following disclaimer in the
 *    documentation and/or other materials provided with the distribution.
 * 3. All advertising materials mentioning features or use of this software
 *    must display the following acknowledgement:
 *    This product includes software developed by the <organization>.
 * 4. Neither the name of the <organization> nor the
 *    names of its contributors may be used to endorse or promote products
 *    derived from this software without specific prior written permission.
 * 
 * THIS SOFTWARE IS PROVIDED BY Paul Headington \'AS IS\' AND ANY
 * EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE IMPLIED
 * WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE ARE
 * DISCLAIMED. IN NO EVENT SHALL <COPYRIGHT HOLDER> BE LIABLE FOR ANY
 * DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES
 * (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES;
 * LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND
 * ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT
 * (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE OF THIS
 * SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
 */

namespace OnyxPrize\Validator;

/**
 * Description of EnteredDaily
 *
 * @author paul
 */
 
use Zend\Validator\Db\AbstractDb;
use Zend\Validator\Exception;
use Zend\Db\Sql\Select;
use Zend\Db\Sql\Sql;
                     
class EnteredDaily extends AbstractDb
{
    const ENTEREDDAILY = 'ENTEREDDAILY';
 
    protected $messageTemplates = array(
        self::ENTEREDDAILY => 'You have already entered today',
    );
     
    public function __construct(array $options = array())
    {
       parent::__construct($options);
    }
 
    public function isValid($value)
    {
       /*
        * Check for an adapter being defined. If not, throw an exception.
        */
        if (null === $this->adapter) {
        throw new Exception\RuntimeException('No database adapter present');
        }

        $valid = true;
        $this->setValue($value);

        $result = $this->query($value);
        
       if ($result) {
           $this->error(self::ENTEREDDAILY);
           return false;
       }
 
       return true;
    }
    
    /**
     * Run query and returns matches, or null if no matches are found.
     *
     * @param  string $value
     * @return array when matches are found.
     */
    protected function query($value)
    {
        $sql = new Sql($this->getAdapter());
        $select = $this->getSelect();
        $select->where->between('postdate', date('Y-m-d 0:00:00'), date('Y-m-d 23:59:59'));
        //echo $sql->getSqlstringForSqlObject($select); die ; 
        $statement = $sql->prepareStatementForSqlObject($select);
        $parameters = $statement->getParameterContainer();
        $parameters['where1'] = $value;
        $result = $statement->execute();

        return $result->current();
    }
}

?>
